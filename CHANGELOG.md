# Changelog

## 12.0 — 2026-11-08

- No longer need to use a deprecated behavior
- Update HTMLToMarkdown submodule to 5.2.3 and some unreleased fixes
- Update HTMLToMarkdown submodule to 5.1.3
- Cope with new behavior coreContentFilterV2 instead of coreContentFilter
- Cope with RTL

## 11.2 — 2026-09-14

- Forgot this one :-p

## 11.1 — 2026-09-14

- Fix CSS for RTL
- Use Html/Form/Note rather than Para when it is applicable
- Enforces some verification before registering module

## 11.0 — 2026-08-03

- Display icon on quick entry (markdown, wiki or html)
- Avoid using magic methods for user preferences and blog settings (2.39+)
- Use MetaRecord::strField(), MetaRecord::intField() and MetaRecord::boolField() whenever is possible
- Review icon colors (DC 2.39+)
- Replace span info ( &gt; format ) on tabs if possible by syntax image
- Use dotclear.ToolBar rather than old jsToolBar, DC 2.39+

## 10.2 — 2026-05-06

- Harmonize usage of App::blogWorkspace()::NS_... and App::userWorkspace()::WS_... (and use short version of constant name for types)
- Update submodule

## 10.1 — 2026-04-06

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 10.0 — 2026-02-13

- No more need of shortkey (2.37)

## 9.8 — 2025-12-12

- Add key attribute for toolbar button in order to ignore keyboard layout (2.37+) Keep shortkey in order to keep 2.36 compliance

## 9.7 — 2025-10-16

- Add online help for markdown syntax (en + fr)

## 9.6 — 2025-10-11

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 9.5 — 2025-09-30

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 9.4 — 2025-09-22

- Use backend services rather than static calls

## 9.3 — 2025-09-21

- Uupdate submodules

## 9.2 — 2025-09-15

- Use legacyEditor groups management

## 9.1 — 2025-09-13

- Cope with 3rd parameter of admin???ListHeader/admin???ListValue behaviors

## 9.0.1 — 2025-09-11

- Do not populate additional columns for posts/pages if they not present in main list

## 9.0 — 2025-09-07

- DC 2.36 compliance

## 8.8 — 2025-09-05

- Better icon for entry link

## 8.7 — 2025-09-05

- Review entry link icon

## 8.6 — 2025-08-29

- use entry title as link text if selection is empty (will be operational with Dotclear 2.36+)

## 8.5 — 2025-08-25

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 8.4 — 2025-08-18

- Cope with page conversion

## 8.3 — 2025-08-15

- No more need these tests as 2.35 has been published

## 8.2 — 2025-08-04

- Add a title (back to content &lt;note-number&gt;) in backlink of footnotes

## 8.1 — 2025-07-03

- Cope with link without text content

## 8.0 — 2025-07-03

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 7.11.1 — 2025-07-03

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 7.11 — 2025-07-02

- Do not use HtmlFilter but a lighter way to clean up comment
- Forgot this one, no impact on the actual code but who knows in the future?

## 7.10 — 2025-07-02

- Filter comments

## 7.9 — 2025-06-14

- Add a Convert to Markdown button for HTML entries

## 7.8.1 — 2025-06-14

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 7.8 — 2025-06-14

- Regroup submodules in one directory (libs)

## 7.7 — 2025-06-14

- Add HTML to Markdown helper (from https://github.com/thephpleague/html-to-markdown)

## 7.6 — 2025-06-06

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 7.5 — 2025-06-06

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 7.4 — 2025-06-05

- Add legacyEditor dark icons

## 7.3.2 — 2025-05-26

- And another one

## 7.3.1 — 2025-05-26

- Forgot a double quote

## 7.3 — 2025-05-21

- Use Markdown syntax as far as possible for image insertion ![alt](src){.class} for image [![alt](src){.class}](href "title") for image with link

## 7.2 — 2025-05-20

- Call coreContentFilter behavior for preview button

## 7.1 — 2025-05-06

- Add markdown="1" attribute to details and aside block

## 7.0 — 2025-03-31

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 6.0 — 2025-03-31

- Use TemplateHelper for template blocks/values DC 2.34+

## 5.7 — 2025-03-05

- Plugins adding buttons on legacyEditor/CKEditor should have at least 1010 priority 1005 is reserved for additional syntaxes to legacyEditor (as legacyMarkdown)

## 5.6 — 2025-02-08

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.5 — 2024-08-28

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.4.1 — 2024-06-09

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.4 — 2024-05-19

- Try to use microseconds to avoid collisions between ID prefix the extract and the input content, as the extract and the content are converted independently.

## 5.3 — 2024-05-18

- Review syntax icons, 2.30+

## 5.2.2 — 2023-12-07

- Use alt rather than title for img

## 5.2.1 — 2023-12-04

- For external media, selected text is used for alternate text, title (optional) is really one

## 5.2 — 2023-12-03

- Post commit hook result
- Insertion d'image : - Ne pas utiliser l’attribut `title` dans `img` - Ne pas autoriser de lien avec un `alt` vide dans `img` - Le `title` du lien doit contenir "ouvrir le média" - Ne pas autoriser une légende avec une `alt` vide dans `img` - Ne pas dupliquer le `alt` dans la légende
- Update Markdown lib (add class/id for tables)
- Switch from XHTML to HTML5 for self-closing tags
- Do not more use alternate text as img title
- Update lib

## 5.1.1 — 2023-11-16

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.1 — 2023-10-27

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.0 — 2023-10-24

- 2.28 compliance

## 4.0 — 2023-08-25

- Dotclear 2.27 compliance, PHP 8.1+

## 3.4.3 — 2023-06-28

- Fix media center alignment

## 3.4.2 — 2023-06-27

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 3.4.1 — 2023-06-27

- Add local static $init variable

## 3.4 — 2023-06-23

- Cope with 2.27 media alignment classes (still compatible with 2.26)

## 3.3 — 2023-06-20

- Use admin URLs

## 3.2.1 — 2023-05-22

- Minify fix

## 3.2 — 2023-05-14

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 3.1 — 2023-05-10

- Use My::id() rather than string

## 3.0.1 — 2023-05-04

- Avoid deprecated methods/property

## 3.0 — 2023-05-03

- Prepare 2.26
- Update lib
- Minimize JS
- x
- Minified versions
- New install

## 2.0.1 — 2022-11-29

- Avoid notice on new installation

## 2.0 — 2022-11-27

- Dotclear 2.24 compliance

## 1.20.1 — 2022-08-14

- Usual oups :-)

## 1.20 — 2022-08-13

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 1.19 — 2022-05-19

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 1.18.1 — 2022-05-18

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 1.18 — 2022-04-03

- Forgot this one :-p

## 1.17 — 2022-03-30

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 1.16.1 — 2022-02-17

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 1.16 — 2022-02-08

- Add preview (button) during edition, address #2

## 1.15.1 — 2021-12-28

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 1.15 — 2021-12-24

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 1.14 — 2021-12-22

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 1.13.4 — 2021-12-18

- When inserting media with a legend which impose a figure, put link (if any) around img and not figure

## 1.13.3 — 2021-12-17

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 1.13.2 — 2021-12-17

- Add SVG plugin icon

## 1.13.1 — 2021-12-10

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 1.13 — 2021-12-09

- Review _define.php/dcstore.xml info

## 1.12 — 2021-12-07

- Update default branch in _define.php for alternative repository
- Add alternative repository

## 1.11 — 2021-08-06

- Dotclear 2.19 compliance
- Update michelf submodule
- Add mark button support

## 1.10.1 — 2020-08-23

- Review public message for comment's syntax (add link)

## 1.10 — 2020-08-02

- And here we go \o/
- Add MichelF php-markdown submodule

## 1.9.1 — 2020-07-02

- Fix tpl:CommentHelp message when Markdown is enabled

## 1.9 — 2020-03-30

- No more inline JS
- type="text/javascript" is not more needed with HTML5

## 1.8 — 2020-02-24

- Add details URL
- Add settings (user/blog) bookmarks
- Add support URL
- Create LICENSE
- PHP 7.4 compliance
- ES6 is coming
- short notation for array (array() → [])

## 1.7 — 2018-02-01

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 1.6 — 2016-09-14

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 1.5.1 — 2016-02-09

- PHP 7 compliance
- Using dcPage::cssLoad, dcPage::jsLoad and dcPage::getPF is a better way to load plugin resources

## 1.5 — 2015-06-30

- Add syntax parameter for adminPostEditor behaviour for Dotclear 2.8 (but it is still compatible with 2.7.n)

## 1.4.1 — 2015-01-03

- Args missing on adminPostEditor behaviour callback, next release will be 1.4.1

## 1.4 — 2015-01-01

- use $__autoload feature for public and admin classes

## 1.3.2 — 2014-12-30

- It's not necessary to load some Markdown js stuff if the editor is not dcLegacyEditor.

## 1.3.1 — 2014-12-04

- Version 1.3.1
- Fixes post link insertion

## 1.3 — 2014-11-06

- Fixes internal media insertion
- Add a warning about comments wiki wyntax
- Cope with new dcLegacyEditor (jsToolBar is not more available without it)
- File missing
- Markdown for public comments, next release will be 1.3 (dotclear 2.7 mini)

## 1.2 — 2013-10-04

- new _define.php
- No more $GLOBALS at top level, and various
- various

## 1.1 — 2013-09-10

- Cope with page edition
- Js Indentation
- Add media and entries selectors
- Standard toolbar
- Update to 1.0.1q markdown / 1.2.7 markdown extra
