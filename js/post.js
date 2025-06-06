/*global jsToolBar, dotclear */
'use strict';

dotclear.md_options = dotclear.getData('md_options');

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
  shortkey: 'KeyB',
  shortkey_name: 'B',
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
  shortkey: 'KeyI',
  shortkey_name: 'I',
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
  shortkey: 'KeyU',
  shortkey_name: 'U',
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
  shortkey: 'KeyD',
  shortkey_name: 'D',
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
  fn: {},
  cite_prompt: 'Source URL:',
  lang_prompt: 'Language:',
  prompt(default_cite = '', default_lang = '') {
    const cite = window.prompt(this.elements.md_quote.cite_prompt, default_cite);
    if (cite === null) {
      return null;
    }
    const lang = window.prompt(this.elements.md_quote.lang_prompt, default_lang);
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
    return;
  }
  this.textarea.focus();
};

// code
jsToolBar.prototype.elements.md_code = {
  type: 'button',
  title: 'Code',
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
  fn: {},
  lang_prompt: 'Language:',
  default_lang: 'en',
  prompt(default_lang = '') {
    return window.prompt(this.elements.md_foreign.lang_prompt, default_lang || this.elements.md_foreign.default_lang);
  },
};

jsToolBar.prototype.elements.md_foreign.fn.markdown = function () {
  const lang = this.elements.md_foreign.prompt.call(this);
  if (lang !== null) {
    let stag = '<i';
    const etag = '</i>';
    stag = lang ? `${stag} lang="${lang}">` : `${stag}>`;

    this.encloseSelection(stag, etag);
    return;
  }
  this.textarea.focus();
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
  fn: {
    markdown() {
      this.encloseSelection('\n', '', (str) => `> ${str.replace(/\r/g, '').replace(/\n/g, '\n> ')}`);
    },
  },
};

// pre
jsToolBar.prototype.elements.md_pre = {
  type: 'button',
  title: 'Preformated text',
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
  fn: {
    markdown() {
      this.encloseSelection('', '', (str) => `* ${str.replace(/\r/g, '').replace(/\n/g, '\n* ')}`);
    },
  },
};

// ol
jsToolBar.prototype.elements.md_ol = {
  type: 'button',
  title: 'Ordered list',
  fn: {
    markdown() {
      this.encloseSelection('', '', (str) => `1. ${str.replace(/\r/g, '').replace(/\n/g, '\n1. ')}`);
    },
  },
};

// details
jsToolBar.prototype.elements.md_details = {
  type: 'button',
  title: 'Details block',
  fn: {},
  title_prompt: 'Summary:',
  default_title: '',
  prompt(default_title = '') {
    return window.prompt(this.elements.md_details.title_prompt, default_title || this.elements.md_details.default_title);
  },
};

jsToolBar.prototype.elements.md_details.fn.markdown = function () {
  const title = this.elements.md_details.prompt.call(this);
  if (title !== null) {
    let stag = '<details markdown="1">\n';
    const etag = '\n</details>';
    if (title) {
      stag = `${stag}<summary>${title}</summary>\n`;
    }

    this.encloseSelection(stag, etag);
    return;
  }
  this.textarea.focus();
};

// aside
jsToolBar.prototype.elements.md_aside = {
  type: 'button',
  title: 'Aside',
  fn: {
    markdown() {
      const stag = '<aside markdown="1">\n';
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
  shortkey: 'KeyL',
  shortkey_name: 'L',
  fn: {},
  fncall: {},
  data: {},
  popup(args = '') {
    window.the_toolbar = this;

    this.elements.md_link.data = {};

    window.open(
      this.elements.md_link.open_url + args,
      'dc_popup',
      'alwaysRaised=yes,dependent=yes,toolbar=yes,height=420,width=520,menubar=no,resizable=yes,scrollbars=yes,status=no',
    );
  },
};

jsToolBar.prototype.elements.md_link.fn.markdown = function () {
  this.elements.md_link.popup.call(this);
};

// img
jsToolBar.prototype.elements.md_img = {
  type: 'button',
  title: 'External image',
  fn: {},
  src_prompt: 'Please give image URL:',
  title_prompt: 'Title for this image:',
  default_title: '',
  prompt(default_src = '', default_title = '') {
    let title = default_title || this.elements.md_img.default_title;

    const src = window.prompt(this.elements.md_img.src_prompt, default_src);
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
    return;
  }
  this.textarea.focus();
};

/* Image selector
-------------------------------------------------------- */
jsToolBar.prototype.elements.md_img_select = {
  type: 'button',
  title: 'Image chooser',
  shortkey: 'KeyM',
  shortkey_name: 'M',
  fn: {},
  fncall: {},
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
      const escapeString = (str) => str.replace('&', '&amp;').replace('>', '&gt;').replace('<', '&lt;').replace('"', '&quot;');
      const alignments = {
        left: dotclear.md_options.style.left,
        right: dotclear.md_options.style.right,
        center: dotclear.md_options.style.center,
      };
      const alt = escapeString(str || d.title);
      let legend =
        d.description !== '' && alt.length // No legend if no alt
          ? escapeString(d.description)
          : false;

      // Do not duplicate information
      if (alt === legend) legend = false;

      // Prepare link title if necessary
      const ltitle = alt ? `${escapeString(dotclear.md_options.img_link_title)}` : '';

      // Check if we can use Markdown syntax for this image:
      // ![alt](src){.class} for image
      // [![alt](src){.class}](href "title") for image with link

      if (!legend && (!(d.alignment in alignments) || (d.alignment in alignments && dotclear.md_options.style.class))) {
        // Not a figure, we will return a Markdown syntax
        const extra = d.alignment in alignments ? `{.${alignments[d.alignment]}}` : '';
        // No alignement or an alignement with class
        const img = `![${alt}](${d.src})${extra}`;
        if (d.link && alt.length && ltitle.length) {
          // Enclose image in a link
          return `[${img}](${d.url} "${ltitle}")`;
        }
        return img;
      }

      // Cannot use Markdown syntax, continue with HTML
      let img = `<img src="${d.src}" alt="${alt}"`;
      let figure = '<figure';
      const caption = legend ? `<figcaption>${legend}</figcaption>\n` : '';

      // Cope with required alignment
      if (d.alignment in alignments) {
        if (legend) {
          figure = `${figure} ${dotclear.md_options.style.class ? 'class' : 'style'}="${alignments[d.alignment]}"`;
        } else {
          img = `${img} ${dotclear.md_options.style.class ? 'class' : 'style'}="${alignments[d.alignment]}"`;
        }
      }

      img = `${img}>`;
      figure = `${figure}>`;

      if (d.link && alt.length) {
        // Enclose image with link (only if non empty alt)
        img = `<a href="${d.url}" title="${ltitle}">${img}</a>`;
      }

      return legend ? `${figure}\n${img}\n${caption}</figure>` : img;
    });
  } else {
    this.textarea.focus();
  }
};

// MP3 helper
//jsToolBar.prototype.elements.mp3_insert = { fncall: {}, data: {} };
jsToolBar.prototype.elements.mp3_insert.fncall.markdown = function () {
  const d = this.elements.mp3_insert.data;
  if (d.player === undefined) {
    return;
  }

  this.encloseSelection('', '', () => `\n${d.player}\n`);
};

// FLV helper
//jsToolBar.prototype.elements.flv_insert = { fncall: {}, data: {} };
jsToolBar.prototype.elements.flv_insert.fncall.markdown = function () {
  const d = this.elements.flv_insert.data;
  if (d.player === undefined) {
    return;
  }

  this.encloseSelection('', '', () => `\n${d.player}\n`);
};

/* Posts selector
-------------------------------------------------------- */
jsToolBar.prototype.elements.md_post_link = {
  type: 'button',
  title: 'Link to an entry',
  shortkey: 'KeyE',
  shortkey_name: 'E',
  fn: {},
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

// Link helper
// Note link.fncall used by md_post_link is also be used by md_link button (see above)
jsToolBar.prototype.elements.link.fncall.markdown = function () {
  const link = this.elements.link.data;
  if (link && link.href !== undefined) {
    const stag = '[';
    const title = link.title ? ` "${link.title}"` : '';
    let etag = `](${link.href}${title})`;

    if (link?.hreflang) {
      etag = `${etag}{hreflang=${link.hreflang}}`;
    }

    this.encloseSelection(stag, etag);
    return;
  }
  this.textarea.focus();
};

/* Footnote helper
-------------------------------------------------------- */
jsToolBar.prototype.elements.md_footnote = {
  type: 'button',
  title: 'Footnote',
  shortkey: 'KeyN',
  shortkey_name: 'N',
  fn: {
    markdown() {
      let counter = 0;
      // Get current selection
      const start = this.textarea.selectionStart;
      const end = this.textarea.selectionEnd;
      const sel = this.textarea.value.substring(start, end);
      // Get next footnote counter
      const matches = [...this.textarea.value.matchAll(/\[\^(\d*)\]/g)];
      if (matches.length > 0) {
        counter = Math.max(...matches.map((c) => Number.parseInt(c[1])));
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
  shortkey: 'KeyP',
  shortkey_name: 'P',
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
dotclear.mergeDeep(jsToolBar.prototype.elements, dotclear.getData('md_editor'));
