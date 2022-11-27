/*global jsToolBar, dotclear, $ */
'use strict';

// Elements definition ------------------------------------

// block format (paragraph, headers)
jsToolBar.prototype.elements.md_blocks = {
  type: 'combo',
  title: 'block format',
  options: {
    none: '-- none --', // only for wysiwyg mode
    nonebis: '- block format -', // only for html/markdown mode
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
    fn(opt) {
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
  icon: 'index.php?pf=formatting-markdown/img/bt_strong.svg',
  fn: {
    markdown() {
      this.singleTag('**');
    },
  },
};

// em
jsToolBar.prototype.elements.md_em = {
  type: 'button',
  title: 'Emphasis',
  icon: 'index.php?pf=formatting-markdown/img/bt_em.svg',
  fn: {
    markdown() {
      this.singleTag('*');
    },
  },
};

// ins
jsToolBar.prototype.elements.md_ins = {
  type: 'button',
  title: 'Inserted',
  icon: 'index.php?pf=formatting-markdown/img/bt_ins.svg',
  fn: {
    markdown() {
      this.singleTag('<ins>', '</ins>');
    },
  },
};

// del
jsToolBar.prototype.elements.md_del = {
  type: 'button',
  title: 'Deleted',
  icon: 'index.php?pf=formatting-markdown/img/bt_del.svg',
  fn: {
    markdown() {
      this.singleTag('<del>', '</del>');
    },
  },
};

// quote
jsToolBar.prototype.elements.md_quote = {
  type: 'button',
  title: 'Inline quote',
  icon: 'index.php?pf=formatting-markdown/img/bt_quote.svg',
  fn: {},
  cite_prompt: 'Source URL:',
  lang_prompt: 'Language:',
  prompt(cite = '', lang = '') {
    cite = window.prompt(this.elements.md_quote.cite_prompt, cite);
    if (cite === null) {
      return null;
    }
    lang = window.prompt(this.elements.md_quote.lang_prompt, lang);
    if (lang === null) {
      return null;
    }
    return {
      cite,
      lang,
    };
  },
};
jsToolBar.prototype.elements.md_quote.fn.markdown = function () {
  const quote = this.elements.md_quote.prompt.call(this);
  if (quote !== null) {
    let stag = '<q';
    const etag = '</q>';
    stag = quote.cite ? `${stag} cite="${quote.cite}"` : stag;
    stag = quote.lang ? `${stag} lang="${quote.lang}"` : stag;
    stag = `${stag}>`;

    this.encloseSelection(stag, etag);
  } else {
    this.textarea.focus();
  }
};

// code
jsToolBar.prototype.elements.md_code = {
  type: 'button',
  title: 'Code',
  icon: 'index.php?pf=formatting-markdown/img/bt_code.svg',
  fn: {
    markdown() {
      this.singleTag('`');
    },
  },
};

// mark
jsToolBar.prototype.elements.md_mark = {
  type: 'button',
  title: 'Mark',
  icon: 'index.php?pf=formatting-markdown/img/bt_mark.svg',
  fn: {
    markdown() {
      this.singleTag('<mark>', '</mark>');
    },
  },
};

// foreign text
jsToolBar.prototype.elements.md_foreign = {
  type: 'button',
  title: 'Foreign text',
  icon: 'index.php?pf=formatting-markdown/img/bt_foreign.svg',
  fn: {},
  lang_prompt: 'Language:',
  default_lang: 'en',
  prompt(lang = '') {
    lang = lang || this.elements.md_foreign.default_lang;
    return window.prompt(this.elements.md_foreign.lang_prompt, lang);
  },
};

jsToolBar.prototype.elements.md_foreign.fn.markdown = function () {
  const lang = this.elements.md_foreign.prompt.call(this);
  if (lang !== null) {
    let stag = '<i';
    const etag = `</i>`;
    stag = lang ? `${stag} lang="${lang}">` : `${stag}>`;

    this.encloseSelection(stag, etag);
  } else {
    this.textarea.focus();
  }
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
  icon: 'index.php?pf=formatting-markdown/img/bt_br.svg',
  fn: {
    markdown() {
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
  icon: 'index.php?pf=formatting-markdown/img/bt_bquote.svg',
  fn: {
    markdown() {
      this.encloseSelection('\n', '', (str) => {
        str = str.replace(/\r/g, '');
        return `> ${str.replace(/\n/g, '\n> ')}`;
      });
    },
  },
};

// pre
jsToolBar.prototype.elements.md_pre = {
  type: 'button',
  title: 'Preformated text',
  icon: 'index.php?pf=formatting-markdown/img/bt_pre.svg',
  fn: {
    markdown() {
      const stag = '<pre>\n';
      const etag = '\n</pre>';
      this.encloseSelection(stag, etag);
    },
  },
};

// ul
jsToolBar.prototype.elements.md_ul = {
  type: 'button',
  title: 'Unordered list',
  icon: 'index.php?pf=formatting-markdown/img/bt_ul.svg',
  fn: {
    markdown() {
      this.encloseSelection('', '', (str) => {
        str = str.replace(/\r/g, '');
        return `* ${str.replace(/\n/g, '\n* ')}`;
      });
    },
  },
};

// ol
jsToolBar.prototype.elements.md_ol = {
  type: 'button',
  title: 'Ordered list',
  icon: 'index.php?pf=formatting-markdown/img/bt_ol.svg',
  fn: {
    markdown() {
      this.encloseSelection('', '', (str) => {
        str = str.replace(/\r/g, '');
        return `1. ${str.replace(/\n/g, '\n1. ')}`;
      });
    },
  },
};

// details
jsToolBar.prototype.elements.md_details = {
  type: 'button',
  title: 'Details block',
  icon: 'index.php?pf=formatting-markdown/img/bt_details.svg',
  fn: {},
  title_prompt: 'Summary:',
  default_title: '',
  prompt(title = '') {
    title = title || this.elements.md_details.default_title;
    return window.prompt(this.elements.md_details.title_prompt, title);
  },
};

jsToolBar.prototype.elements.md_details.fn.markdown = function () {
  const title = this.elements.md_details.prompt.call(this);
  if (title !== null) {
    let stag = '<details>\n';
    const etag = `\n</details>`;
    if (title) {
      stag = `${stag}<summary>${title}</summary>\n`;
    }

    this.encloseSelection(stag, etag);
  } else {
    this.textarea.focus();
  }
};

// aside
jsToolBar.prototype.elements.md_aside = {
  type: 'button',
  title: 'Aside',
  icon: 'index.php?pf=formatting-markdown/img/bt_aside.svg',
  fn: {
    markdown() {
      const stag = '<aside>\n';
      const etag = '\n</aside>';
      this.encloseSelection(stag, etag);
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
  icon: 'index.php?pf=formatting-markdown/img/bt_link.svg',
  fn: {},
  href_prompt: 'Please give URL:',
  title_prompt: 'Title for this URL:',
  lang_prompt: 'Language:',
  default_title: '',
  default_lang: '',
  prompt(href = '', title = '', lang = '') {
    title = title || this.elements.md_link.default_title;
    lang = lang || this.elements.md_link.default_lang;

    href = window.prompt(this.elements.md_link.href_prompt, href);
    if (!href) {
      return null;
    }

    title = window.prompt(this.elements.md_link.title_prompt, title);
    if (title === null) {
      return null;
    }
    lang = window.prompt(this.elements.md_link.lang_prompt, lang);
    if (lang === null) {
      return null;
    }

    return {
      href: this.stripBaseURL(href),
      title,
      lang,
    };
  },
};

jsToolBar.prototype.elements.md_link.fn.markdown = function () {
  const link = this.elements.md_link.prompt.call(this);
  if (link !== null && link !== '') {
    const stag = '[';
    let etag = `](${link.href}`;
    if (link.title) {
      etag = `${etag} "${link.title}"`;
    }
    etag = `${etag})`;
    if (link.lang) {
      etag = `${etag}{hreflang=${link.lang}}`;
    }

    this.encloseSelection(stag, etag);
  } else {
    this.textarea.focus();
  }
};

// img
jsToolBar.prototype.elements.md_img = {
  type: 'button',
  title: 'External image',
  icon: 'index.php?pf=formatting-markdown/img/bt_img.svg',
  fn: {},
  src_prompt: 'Please give image URL:',
  title_prompt: 'Title for this image:',
  default_title: '',
  prompt(src = '', title = '') {
    title = title || this.elements.md_img.default_title;

    src = window.prompt(this.elements.md_img.src_prompt, src);
    if (!src) {
      return null;
    }

    title = window.prompt(this.elements.md_img.title_prompt, title);
    if (title === null) {
      return null;
    }

    return {
      src: this.stripBaseURL(src),
      title,
    };
  },
};

jsToolBar.prototype.elements.md_img.fn.markdown = function () {
  const image = this.elements.md_img.prompt.call(this);
  if (image !== null && image !== '') {
    const stag = '![';
    let etag = `](${image.src}`;
    if (image.title) {
      etag = `${etag} "${image.title}"`;
    }
    etag = `${etag})`;

    this.encloseSelection(stag, etag);
  } else {
    this.textarea.focus();
  }
};

/* Image selector
-------------------------------------------------------- */
jsToolBar.prototype.elements.md_img_select = {
  type: 'button',
  title: 'Image chooser',
  icon: 'index.php?pf=formatting-markdown/img/bt_img_select.svg',
  fn: {},
  fncall: {},
  open_url: 'media.php?popup=1&plugin_id=dcLegacyEditor',
  data: {},
  popup() {
    window.the_toolbar = this;
    this.elements.md_img_select.data = {};

    window.open(
      this.elements.md_img_select.open_url,
      'dc_popup',
      'alwaysRaised=yes,dependent=yes,toolbar=yes,height=500,width=760,menubar=no,resizable=yes,scrollbars=yes,status=no',
    );
  },
};
jsToolBar.prototype.elements.md_img_select.fn.markdown = function () {
  this.elements.md_img_select.popup.call(this);
};
jsToolBar.prototype.elements.img_select.fncall.markdown = function () {
  const d = this.elements.img_select.data;
  if (d && d.src !== undefined) {
    this.encloseSelection('', '', (str) => {
      const alignments = {
        left: 'float: left; margin: 0 1em 1em 0;',
        right: 'float: right; margin: 0 0 1em 1em;',
        center: 'margin: 0 auto; display: table;',
      };
      const alt = (str ? str : d.title).replace('&', '&amp;').replace('>', '&gt;').replace('<', '&lt;').replace('"', '&quot;');
      const legend =
        d.description !== ''
          ? d.description.replace('&', '&amp;').replace('>', '&gt;').replace('<', '&lt;').replace('"', '&quot;')
          : false;
      let img = `<img src="${d.src}" alt="${alt}"`;
      let figure = '<figure';
      const caption = legend ? `<figcaption>${legend}</figcaption>\n` : '';

      if (legend) {
        img = `${img} title="${legend}"`;
      }

      // Cope with required alignment
      if (d.alignment in alignments) {
        if (legend) {
          figure = `${figure} style="${alignments[d.alignment]}"`;
        } else {
          img = `${img} style="${alignments[d.alignment]}"`;
        }
      }

      img = `${img} />`;
      figure = `${figure}>`;

      if (d.link) {
        // Enclose image with link
        const ltitle = alt
          ? ` title="${alt.replace('&', '&amp;').replace('>', '&gt;').replace('<', '&lt;').replace('"', '&quot;')}"`
          : '';
        img = `<a href="${d.url}"${ltitle}>${img}</a>`;
      }

      return legend ? `${figure}\n${img}\n${caption}</figure>` : img;
    });
  } else {
    this.textarea.focus();
  }
};

// MP3 helpers
//jsToolBar.prototype.elements.mp3_insert = { fncall: {}, data: {} };
jsToolBar.prototype.elements.mp3_insert.fncall.markdown = function () {
  const d = this.elements.mp3_insert.data;
  if (d.player == undefined) {
    return;
  }

  this.encloseSelection('', '', () => `\n${d.player}\n`);
};

// FLV helpers
//jsToolBar.prototype.elements.flv_insert = { fncall: {}, data: {} };
jsToolBar.prototype.elements.flv_insert.fncall.markdown = function () {
  const d = this.elements.flv_insert.data;
  if (d.player == undefined) {
    return;
  }

  this.encloseSelection('', '', () => `\n${d.player}\n`);
};

/* Posts selector
-------------------------------------------------------- */
jsToolBar.prototype.elements.md_post_link = {
  type: 'button',
  title: 'Link to an entry',
  icon: 'index.php?pf=formatting-markdown/img/bt_post.svg',
  fn: {},
  open_url: 'popup_posts.php?plugin_id=dcLegacyEditor',
  data: {},
  popup() {
    window.the_toolbar = this;
    this.elements.link.data = {};

    window.open(
      this.elements.md_post_link.open_url,
      'dc_popup',
      'alwaysRaised=yes,dependent=yes,toolbar=yes,height=500,width=760,menubar=no,resizable=yes,scrollbars=yes,status=no',
    );
  },
};
jsToolBar.prototype.elements.md_post_link.fn.markdown = function () {
  this.elements.md_post_link.popup.call(this);
};
jsToolBar.prototype.elements.link.fncall.markdown = function () {
  const link = this.elements.link.data;
  if (link && link.href !== undefined) {
    const stag = '[';
    const etag = `](${link.href}${link.title ? ` "${link.title}"` : ''})`;

    this.encloseSelection(stag, etag);
  } else {
    this.textarea.focus();
  }
};

/* Footnote helper
-------------------------------------------------------- */
jsToolBar.prototype.elements.md_footnote = {
  type: 'button',
  title: 'Footnote',
  icon: 'index.php?pf=formatting-markdown/img/bt_footnote.svg',
  fn: {
    markdown() {
      let counter = 0;
      // Get current selection
      const start = this.textarea.selectionStart;
      const end = this.textarea.selectionEnd;
      const sel = this.textarea.value.substring(start, end);
      // Get next footnote counter
      const matches = [...this.textarea.value.matchAll(/\[\^([0-9]*)\]/g)];
      if (matches.length > 0) {
        counter = Math.max(...matches.map((c) => parseInt(c[1])));
      }
      counter += 1;
      const subst = `[^${counter}]`;
      // Replace current selection by footnote link
      this.textarea.value = this.textarea.value.substring(0, start) + subst + this.textarea.value.substring(end);
      // Put current selection on bottom on document with footnote ref
      this.textarea.value = `${this.textarea.value}\n${subst}: ${sel}`;
      // Put caret just after the footnote link
      this.textarea.setSelectionRange(start + subst.length, start + subst.length);
      // End at last, give focus back to textarea
      this.textarea.focus();
    },
  },
};

// spacer
jsToolBar.prototype.elements.md_space4 = {
  type: 'space',
  format: {
    markdown: true,
  },
};

// Preview
jsToolBar.prototype.elements.md_preview = {
  type: 'button',
  title: 'Preview',
  icon: 'index.php?pf=formatting-markdown/img/bt_preview.svg',
  fn: {
    markdown() {
      dotclear.services(
        'markdownConvert',
        (data) => {
          try {
            const response = JSON.parse(data);
            if (response?.success) {
              if (response?.payload.ret) {
                $.magnificPopup.open({
                  items: {
                    src: `<div class="md_preview"><div class="md_markup">${response.payload.html}</div></div>`,
                    type: 'inline',
                  },
                });
              }
            } else {
              console.log(dotclear.debug && response?.message ? response.message : 'Dotclear REST server error');
              return;
            }
          } catch (e) {
            console.log(e);
          }
        },
        (error) => {
          console.log(error);
        },
        false, // Use POST as buffer might be too large for URL GET pamareter
        {
          json: 1,
          md: this.textarea.value,
        },
      );
    },
  },
};

/* Set options
---------------------------------------------------------- */
dotclear.mergeDeep(jsToolBar.prototype.elements, dotclear.getData('formatting_markdown'));
