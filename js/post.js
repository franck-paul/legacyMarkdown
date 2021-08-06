/*global jsToolBar, dotclear */
'use strict';

// Elements definition ------------------------------------

// block format (paragraph, headers)
jsToolBar.prototype.elements.md_blocks = {
  type: 'combo',
  title: 'block format',
  options: {
    none: '-- none --', // only for wysiwyg mode
    nonebis: '- block format -', // only for xhtml mode
    p: 'Paragraph',
    h1: 'Header 1',
    h2: 'Header 2',
    h3: 'Header 3',
    h4: 'Header 4',
    h5: 'Header 5',
    h6: 'Header 6',
  },
  markdown: {
    list: ['nonebis', 'h3', 'h4', 'h5'],
    fn: function (opt) {
      switch (opt) {
        case 'nonebis':
          this.textarea.focus();
          break;
        case 'h3':
          this.encloseSelection('### ');
          break;
        case 'h4':
          this.encloseSelection('#### ');
          break;
        case 'h5':
          this.encloseSelection('##### ');
          break;
      }
      this.toolNodes.md_blocks.value = 'nonebis';
    },
  },
};

// spacer
jsToolBar.prototype.elements.md_space0 = {
  type: 'space',
  format: {
    markdown: true,
  },
};

// strong
jsToolBar.prototype.elements.md_strong = {
  type: 'button',
  title: 'Strong emphasis',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_strong.png',
  fn: {
    markdown: function () {
      this.singleTag('**');
    },
  },
};

// em
jsToolBar.prototype.elements.md_em = {
  type: 'button',
  title: 'Emphasis',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_em.png',
  fn: {
    markdown: function () {
      this.singleTag('*');
    },
  },
};

// ins
jsToolBar.prototype.elements.md_ins = {
  type: 'button',
  title: 'Inserted',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_ins.png',
  fn: {
    markdown: function () {
      this.singleTag('<ins>', '</ins>');
    },
  },
};

// del
jsToolBar.prototype.elements.md_del = {
  type: 'button',
  title: 'Deleted',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_del.png',
  fn: {
    markdown: function () {
      this.singleTag('<del>', '</del>');
    },
  },
};

// quote
jsToolBar.prototype.elements.md_quote = {
  type: 'button',
  title: 'Inline quote',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_quote.png',
  fn: {
    markdown: function () {
      this.singleTag('<q>', '</q>');
    },
  },
};

// code
jsToolBar.prototype.elements.md_code = {
  type: 'button',
  title: 'Code',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_code.png',
  fn: {
    markdown: function () {
      this.singleTag('`');
    },
  },
};

// quote
jsToolBar.prototype.elements.md_mark = {
  type: 'button',
  title: 'Mark',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_mark.png',
  fn: {
    markdown: function () {
      this.singleTag('<mark>', '</mark>');
    },
  },
};

// spacer
jsToolBar.prototype.elements.md_space1 = {
  type: 'space',
  format: {
    markdown: true,
  },
};

// br
jsToolBar.prototype.elements.md_br = {
  type: 'button',
  title: 'Line break',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_br.png',
  fn: {
    markdown: function () {
      this.encloseSelection('  \n', '');
    },
  },
};

// spacer
jsToolBar.prototype.elements.md_space2 = {
  type: 'space',
  format: {
    markdown: true,
  },
};

// blockquote
jsToolBar.prototype.elements.md_blockquote = {
  type: 'button',
  title: 'Blockquote',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_bquote.png',
  fn: {
    markdown: function () {
      this.encloseSelection('\n', '', function (str) {
        str = str.replace(/\r/g, '');
        return '> ' + str.replace(/\n/g, '\n> ');
      });
    },
  },
};

// pre
jsToolBar.prototype.elements.md_pre = {
  type: 'button',
  title: 'Preformated text',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_pre.png',
  fn: {
    markdown: function () {
      this.encloseSelection('\n', '', function (str) {
        str = str.replace(/\r/g, '');
        return '    ' + str.replace(/\n/g, '\n    ');
      });
    },
  },
};

// ul
jsToolBar.prototype.elements.md_ul = {
  type: 'button',
  title: 'Unordered list',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_ul.png',
  fn: {
    markdown: function () {
      this.encloseSelection('', '', function (str) {
        str = str.replace(/\r/g, '');
        return '* ' + str.replace(/\n/g, '\n* ');
      });
    },
  },
};

// ol
jsToolBar.prototype.elements.md_ol = {
  type: 'button',
  title: 'Ordered list',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_ol.png',
  fn: {
    markdown: function () {
      this.encloseSelection('', '', function (str) {
        str = str.replace(/\r/g, '');
        return '1. ' + str.replace(/\n/g, '\n1. ');
      });
    },
  },
};

// spacer
jsToolBar.prototype.elements.md_space3 = {
  type: 'space',
  format: {
    markdown: true,
  },
};

// link
jsToolBar.prototype.elements.md_link = {
  type: 'button',
  title: 'Link',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_link.png',
  fn: {},
  href_prompt: 'Please give URL:',
  title_prompt: 'Title for this URL:',
  default_title: '',
  prompt: function (href, title) {
    href = href || '';
    title = title || this.elements.md_link.default_title;

    href = window.prompt(this.elements.md_link.href_prompt, href);
    if (!href) {
      return false;
    }

    title = window.prompt(this.elements.md_link.title_prompt, title);

    return {
      href: this.stripBaseURL(href),
      title: title,
    };
  },
};

jsToolBar.prototype.elements.md_link.fn.markdown = function () {
  const link = this.elements.md_link.prompt.call(this);
  if (link) {
    const stag = '[';
    let etag = '](' + link.href;
    if (link.title) {
      etag = etag + ' "' + link.title + '"';
    }
    etag = etag + ')';

    this.encloseSelection(stag, etag);
  }
};

// img
jsToolBar.prototype.elements.md_img = {
  type: 'button',
  title: 'External image',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_img.png',
  fn: {},
  src_prompt: 'Please give image URL:',
  title_prompt: 'Title for this image:',
  default_title: '',
  prompt: function (src, title) {
    src = src || '';
    title = title || this.elements.md_img.default_title;

    src = window.prompt(this.elements.md_img.src_prompt, src);
    if (!src) {
      return false;
    }

    title = window.prompt(this.elements.md_img.title_prompt, title);

    return {
      src: this.stripBaseURL(src),
      title: title,
    };
  },
};

jsToolBar.prototype.elements.md_img.fn.markdown = function () {
  const image = this.elements.md_img.prompt.call(this);
  if (image) {
    const stag = '![';
    let etag = '](' + image.src;
    if (image.title) {
      etag = etag + ' "' + image.title + '"';
    }
    etag = etag + ')';

    this.encloseSelection(stag, etag);
  }
};

/* Image selector
-------------------------------------------------------- */
jsToolBar.prototype.elements.md_img_select = {
  type: 'button',
  title: 'Image chooser',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_img_select.png',
  fn: {},
  fncall: {},
  open_url: 'media.php?popup=1&plugin_id=dcLegacyEditor',
  data: {},
  popup: function () {
    window.the_toolbar = this;
    this.elements.md_img_select.data = {};

    window.open(
      this.elements.md_img_select.open_url,
      'dc_popup',
      'alwaysRaised=yes,dependent=yes,toolbar=yes,height=500,width=760,' + 'menubar=no,resizable=yes,scrollbars=yes,status=no'
    );
  },
};
jsToolBar.prototype.elements.md_img_select.fn.markdown = function () {
  this.elements.md_img_select.popup.call(this);
};
jsToolBar.prototype.elements.img_select.fncall.markdown = function () {
  const d = this.elements.img_select.data;
  if (d.src == undefined) {
    return;
  }

  this.encloseSelection('', '', function (str) {
    const alt = str ? str : d.title;
    let res = `<img src="${d.src}" alt="${alt
      .replace('&', '&amp;')
      .replace('>', '&gt;')
      .replace('<', '&lt;')
      .replace('"', '&quot;')}"`;

    if (d.alignment == 'left') {
      res += ' style="float: left; margin: 0 1em 1em 0;"';
    } else if (d.alignment == 'right') {
      res += ' style="float: right; margin: 0 0 1em 1em;"';
    } else if (d.alignment == 'center') {
      res += ' style="margin: 0 auto; display: block;"';
    }

    if (d.description) {
      res += ` title="${d.description.replace('&', '&amp;').replace('>', '&gt;').replace('<', '&lt;').replace('"', '&quot;')}"`;
    }

    res += ' />';

    if (d.link) {
      const ltitle = alt
        ? ` title="${alt.replace('&', '&amp;').replace('>', '&gt;').replace('<', '&lt;').replace('"', '&quot;')}"`
        : '';
      res = `<a href="${d.url}"${ltitle}>${res}</a>`;
    }

    return res;
  });
};

// MP3 helpers
//jsToolBar.prototype.elements.mp3_insert = { fncall: {}, data: {} };
jsToolBar.prototype.elements.mp3_insert.fncall.markdown = function () {
  const d = this.elements.mp3_insert.data;
  if (d.player == undefined) {
    return;
  }

  this.encloseSelection('', '', () => '\n' + d.player + '\n');
};

// FLV helpers
//jsToolBar.prototype.elements.flv_insert = { fncall: {}, data: {} };
jsToolBar.prototype.elements.flv_insert.fncall.markdown = function () {
  const d = this.elements.flv_insert.data;
  if (d.player == undefined) {
    return;
  }

  this.encloseSelection('', '', () => '\n' + d.player + '\n');
};

/* Posts selector
-------------------------------------------------------- */
jsToolBar.prototype.elements.md_post_link = {
  type: 'button',
  title: 'Link to an entry',
  icon: 'index.php?pf=dcLegacyEditor/css/jsToolBar/bt_post.png',
  fn: {},
  open_url: 'popup_posts.php?plugin_id=dcLegacyEditor',
  data: {},
  popup: function () {
    window.the_toolbar = this;
    this.elements.link.data = {};

    window.open(
      this.elements.md_post_link.open_url,
      'dc_popup',
      'alwaysRaised=yes,dependent=yes,toolbar=yes,height=500,width=760,' + 'menubar=no,resizable=yes,scrollbars=yes,status=no'
    );
  },
};
jsToolBar.prototype.elements.md_post_link.fn.markdown = function () {
  this.elements.md_post_link.popup.call(this);
};
jsToolBar.prototype.elements.link.fncall.markdown = function () {
  const link = this.elements.link.data;
  if (link.href == undefined) {
    return;
  }

  if (link) {
    const stag = '[';
    const etag = `](${link.href}${link.title ? ` "${link.title}"` : ''})`;

    this.encloseSelection(stag, etag);
  }
};

/* Set options
---------------------------------------------------------- */
dotclear.mergeDeep(jsToolBar.prototype.elements, dotclear.getData('formatting_markdown'));
