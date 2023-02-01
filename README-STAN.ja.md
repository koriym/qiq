# 静的解析 POC

※ Proof of Concept：概念実証

このブランチは、Qiq テンプレートファイルの静的解析を有効にするための概念的な証明です。

tl;dr:

- HelperLocatorは廃止され、Helperオブジェクトが採用されました。
- ヘルパーを作るには、拡張ヘルパーオブジェクトにメソッドを追加し、拡張ヘルパーオブジェクトをテンプレートにインジェクトします。
- 代入される変数は `$foo` であり、`$this->foo` ではありません。
- 静的解析を可能にするため、テンプレートファイル内で交差点タイプヒントを使用します。

## 1.x との相違点

### ヘルパー

HelperLocator がなくなり、代わりに Helpers オブジェクトが追加され、内部で ContainerInterface が使用されるようになリマス。

バンドルされているContainerInterfaceの実装は自動配線で軽く設定できるが、意図的に低機能で、主に依存関係の少ない単純なオブジェクトに適しています。

#### カスタムヘルパーオブジェクトの拡張とインジェクション

独自のヘルパーを追加するには、まず Helpers クラスを拡張します ...

```php
class MyHelpers extends Helpers
{
    use \HtmlHelperMethods;
}
```

そして、テンプレート作成時に拡張したHelperを使用します。

```php
$tpl = Template::new(
    paths: ...,
    extension: ...,
    helpers: new MyHelpers()
);
```

#### ヘルパーメソッドの作成

これで、拡張ヘルパーオブジェクトの public 関数としてヘルパーメソッドを追加できるようになりました。

```php
class MyHelpers extends Helpers
{
    use \QiqHelperMethods;

    public function rot13(string $$raw) : string
    {
        return str_rot13($raw);
    }
}
```

#### ヘルパーオブジェクトの作成

複雑なヘルパーロジックでは、ヘルパーオブジェクトを作りたくなることもあるでしょう。Helpers::get() メソッドでヘルパーオブジェクトをコンテナインターフェースから取得することでこのオブジェクトにアクセスできます。

```php
class Rot13Helper
{
    public function __invoke(string $raw) : string
    {
        return str_rot13($raw);
    }
}

class MyHelpers extends Helpers
{
    use \Qiq\Helper\Html\HtmlHelperMethods;

    public function rot13(string $$raw) : string
    {
        return $this->get(Rot13Helper::class)->__invoke($raw);
    }
}
```

#### ヘルパーの共有

ヘルパーのセットを共有するには、ヘルパー用のtraitを作成し、ヘルパーオブジェクトでそのtraitを使用します。

```php
trait MyHelperMethods
{
    public function rot13(string $$raw) : string
    {
        return $this->get(Rot13Helper::class)->__invoke($raw);
    }
}

class MyHelpers extends Helpers
{
    use \Qiq\Helper\Html\HtmlHelperMethods;
    use MyHelperMethods;
}
```

#### ヘルパーの使い方

テンプレートファイル内では、従来通り `<?= $this->rot13('foo') ?>` (または `{{= rot13 ('foo') }}`) を呼び出すことができます。


### テンプレート変数

代入された変数は、もはや `$this` を使ってアドレス指定されることはありません。つまり、 `$template->setData(['bar' => 'baz'])` を代入すると、テンプレートファイルでは *used* ... を使用します。

```html+php
<?= $this->bar ?>
```

... しかし、現在では

```html+php
<?= $bar ?>
```

代入された変数は参照によってテンプレート間で共有されるので、あるテンプレートで代入された変数への変更は他のすべてのテンプレートで認識されます。

render()` 時点で設定されるローカル変数は、共有されません* (これは現在の動作なので、変更はありません)。

例えば、 `$item` に *also* が割り当てられているときに `foreach ($items as $item)` を使用すると、割り当てられたものとローカル変数の衝突の可能性が大きくなります。foreach() は、代入された `$item` の値を上書きします。(古い方法では、`foreach ($this->items as $item)`は代入された値を上書きする可能性はほとんどありません)。


### 静的解析

テンプレートファイル内の静的解析を有効にするには、テンプレートファイルに `@var ... $this` ヒントがあり、_QiqRendering_ interface **and** 使用中の _Helpers_ オブジェクトの交差点にタイプされている必要があります。

```html+php
<?php
/**
 * @var Qiq\Rendering&Qiq\Helper\Html\HtmlHelpers $this
 */
?>

<?= $this->anchor(...) ?>
```

このテンプレートファイルを静的解析すると、`$this->anchor()`がHtmlHelpersクラスのメソッドであることが認識されるはずです。

テンプレート変数を静的解析できるようにするには、テンプレートファイル内で変数をドキュメント化します。

```html+php
<?php
/**
 * @var Qiq\Rendering&MyHelpers $this
 * @var string $bar
 */
?>

<?= $this->rot13($bar) ?>
```

これは、Qiq の `{{ ... }} 構文を使っているファイルに対しても有効です。}}` 構文でも動作します。

```qiq
{{ /** @var Qiq\Rendering&MyHelpers $this */ }}
{{ /** @var string $bar */ }}

{{= rot13 ($bar) }}
```

しかし、Qiq 構文を使ったテンプレートの静的解析は、テンプレートの **コンパイル済み** バージョンに対して行う必要があります。つまり、静的解析を行う前に、すべてのテンプレートをコンパイルし、コンパイルされたテンプレートを格納するディレクトリを解析ツールに指定する必要があります。

このような複雑な `@var ... $this` タイプヒントは、不快に感じるかもしれません。もしそうなら、 _Template_ クラスを拡張して、コンストラクタをオーバーライドし、拡張された _Helpers_ オブジェクトを指す `@mixin` タグを追加することを検討してください。

```php
/**
 * @mixin MyHelpers
 */
class MyTemplate extends \Qiq\Template
{
    public function __construct(
        Catalog $catalog,
        Compiler $compiler,
        MyHelpers $helpers
    ) {
        parent::__construct($catalog, $compiler, $helpers);
    }
}
```

これで、テンプレートファイルのtypehintは以下のように減らすことができます。

```qiq
{{ /** @var MyTemplate $this */ }}
```

コンストラクタのオーバーライドは、特定のカタログやコンパイラにタイプヒントを与え、その後親コンストラクタを呼び出すことができるため、依存性注入を自動化するのに適していることがわかるかもしれません。
