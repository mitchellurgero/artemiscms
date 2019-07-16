## Artemis CMS

:new_moon:

Moon Powered CMS!


## What is Artemis?

Artemis is a flat-file, markdown based CMS that is the successor to [BootWiki](https://github.com/mitchellurgero/bootwiki). It is lighter, faster, and smaller. Artemis supports HTML, Markdown, and Markdown Extra using [Parsedown](https://parsedown.org/)
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

## Creating new pages

New pages are pretty easy to create. Just make a new file anywhere under `app/pages` and it is accessible via Artemis. These files may be in sub-folders as well. Pages can be Markdown or HTML and follow a basic layout.

The following displays the bare minimum for a page to function properly:

`example.md`

```markdown
---
title = Example
date  = November 2nd, 2019
desc  = Example Page
author = John Smith
---

## Example Page

This is an example page.

```

The part of the page in the "---" section is an ini formatted configuration. For now this stores basic information for SEO and for some backend stuff as well.

Pages can also be in sub-folders. If you want to link to a folder instead of a page file, you can use `index.md` files (formatted the same as normal pages) as if it was an index.html file. See the example `app/pages/folder1` folder for how it should look.


## Linking to other pages

If you need to link to other pages from another page it should follow the full url for the site instead of just a file path. 

Example:

```
[Link 1](https://example.com/link1.md)
```

or

```
<a href="https://example.com/link1.md">Link 1</a>
```