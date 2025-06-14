Dotclear 2 plugin

[![Release](https://img.shields.io/github/v/release/franck-paul/legacyMarkdown)](https://github.com/franck-paul/legacyMarkdown/releases)
[![Date](https://img.shields.io/github/release-date/franck-paul/legacyMarkdown)](https://github.com/franck-paul/legacyMarkdown/releases)
[![Issues](https://img.shields.io/github/issues/franck-paul/legacyMarkdown)](https://github.com/franck-paul/legacyMarkdown/issues)
[![Dotaddict](https://img.shields.io/badge/dotaddict-official-green.svg)](https://plugins.dotaddict.org/dc2/details/legacyMarkdown)
[![License](https://img.shields.io/github/license/franck-paul/legacyMarkdown)](https://github.com/franck-paul/legacyMarkdown/blob/master/LICENSE)

----

Based on: Michel Fortin [Library](https://github.com/michelf/php-markdown/)

----

Using Markdown to HTML:

```language-php
use Dotclear\Plugin\legacyMarkdown\Helper as Markdown;

$markdown = '### Quick, to the Batpoles!';
$html = Markdown::convert($markdown);   // <h3>Quick, to the Batpoles!</h3>
```

or:

```language-php
$markdown = '### Quick, to the Batpoles!';
$html = \Dotclear\Plugin\legacyMarkdown\Helper::convert($markdown);   // <h3>Quick, to the Batpoles!</h3>
```

----

Using HTML to Markdown (standard Markdown syntax only):

```language-php
use Dotclear\Plugin\legacyMarkdown\Helper as Markdown;

$html = '<h3>Quick, to the Batpoles!</h3>';
$markdown = Markdown::fromHTML($html);  // ### Quick, to the Batpoles!
```

or:

```language-php
$html = '<h3>Quick, to the Batpoles!</h3>';
$markdown = \Dotclear\Plugin\legacyMarkdown\Helper::fromHTML($html);    // ### Quick, to the Batpoles!
```

----

Notes:

- This plugin has been renamed from `formatting-markdown` to `legacyMarkdown` since version 3.0.
- During installation of version 3.0+ the old plugin will be disabled if existing and enabled.
