## Artemis CMS

:new_moon:

Moon Powered CMS!


## What is Artemis?

Artemis is a flat-file, markdown based CMS that is the successor to [BootWiki](). It is lighter, faster, and smaller. Artemis supports HTML, Markdown, and Markdown Extra using [Parsedown](https://parsedown.org/)
JavaScript is also supported.

## Features

- Markdown Processing (Including Markdown Extra)
- Inline HTML supported
- Easy drag-and-drop install
- Lightweight (Can even be hosted on Raspberry Pi Zero's, free hosting, etc.)
- Fancy URLS (Requires Apache Rewrite Module!)

## Installing

1. Clone or download this repository
2. Put all files into your web root on your web server. This can be in a sub directory as well.
3. Copy config.example.php to config.php (`cp config.example.php config.php`)
4. Edit config.php to your liking.

## Theme Support

Artemis supports basic Bootstrap 4 themes, a few have been included from [bootswatch](https://bootswatch.com/) however, you can make your own so long as it's a self-sustained single bootstrap.css file.

Custom themes can go in the `app/theme` folder.