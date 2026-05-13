/*global dotclear */
'use strict';

dotclear.md_options = dotclear.getData('md_options');

// Elements definition ------------------------------------

// block format (paragraph, headers)
dotclear.ToolBar.prototype.elements.md_blocks = {
  group: 'header',
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

// strong
dotclear.ToolBar.prototype.elements.md_strong = {
  group: 'format',
  type: 'button',
  title: 'Strong emphasis',
  key: 'b',
  shortkey_name: 'B',
  fn: {
    markdown() {
      this.singleTag('**');
    },
  },
};

// em
dotclear.ToolBar.prototype.elements.md_em = {
  group: 'format',
  type: 'button',
  title: 'Emphasis',
  key: 'i',
  shortkey_name: 'I',
  fn: {
    markdown() {
      this.singleTag('*');
    },
  },
};

// ins
dotclear.ToolBar.prototype.elements.md_ins = {
  group: 'format',
  type: 'button',
  title: 'Inserted',
  key: 'u',
  shortkey_name: 'U',
  fn: {
    markdown() {
      this.singleTag('<ins>', '</ins>');
    },
  },
};

// del
dotclear.ToolBar.prototype.elements.md_del = {
  group: 'format',
  type: 'button',
  title: 'Deleted',
  key: 'd',
  shortkey_name: 'D',
  fn: {
    markdown() {
      this.singleTag('<del>', '</del>');
    },
  },
};

// quote
dotclear.ToolBar.prototype.elements.md_quote = {
  group: 'format',
  type: 'button',
  title: 'Inline quote',
  fn: {},
  async prompt(callback = null) {
    const dialog = new dotclear.ToolBar.Dialog({
      title: this.toolbar.querySelector('.jstb_md_quote')?.title || this.elements.md_quote.title,
      confirm_label: dotclear.md_options.dialog.ok,
      cancel_label: dotclear.md_options.dialog.cancel,
      fields: [
        {
          // Quote URL input
          default: this.elements.md_quote.dialog.default_url,
          html: this.elements.md_quote.dialog.url,
        },
        {
          // Language select
          default: this.elements.md_quote.dialog.default_lang,
          html: this.elements.md_quote.dialog.language,
        },
      ],
    });
    await dialog.prompt().then((choice) => {
      if (choice && callback) {
        const response = JSON.parse(choice);
        callback({
          cite: this.stripBaseURL(response[0]),
          lang: response[1],
        });

        return;
      }
      this.toolbar.querySelector('.jstb_md_quote').focus();
    });
  },
};
dotclear.ToolBar.prototype.elements.md_quote.fn.markdown = async function () {
  await this.elements.md_quote.prompt.call(this, (response) => {
    let start_tag = '<q';
    if (response.cite) {
      start_tag = `${start_tag} cite="${response.cite}"`;
    }
    if (response.lang) {
      start_tag = `${start_tag} lang="${response.lang}"`;
    }
    start_tag = `${start_tag}>`;

    this.encloseSelection(start_tag, '</q>');
  });
};

// code
dotclear.ToolBar.prototype.elements.md_code = {
  group: 'format',
  type: 'button',
  title: 'Code',
  fn: {
    markdown() {
      this.singleTag('`');
    },
  },
};

// mark
dotclear.ToolBar.prototype.elements.md_mark = {
  group: 'format',
  type: 'button',
  title: 'Mark',
  fn: {
    markdown() {
      this.singleTag('<mark>', '</mark>');
    },
  },
};

// foreign text
dotclear.ToolBar.prototype.elements.md_foreign = {
  group: 'format',
  type: 'button',
  title: 'Foreign text',
  fn: {},
  async prompt(callback = null) {
    const dialog = new dotclear.ToolBar.Dialog({
      title: this.toolbar.querySelector('.jstb_md_foreign')?.title || this.elements.md_foreign.title,
      confirm_label: dotclear.md_options.dialog.ok,
      cancel_label: dotclear.md_options.dialog.cancel,
      fields: [
        {
          // Language select
          default: this.elements.md_foreign.dialog.default_lang,
          html: this.elements.md_foreign.dialog.language,
        },
      ],
    });
    await dialog.prompt().then((choice) => {
      if (choice && callback) {
        const response = JSON.parse(choice);
        callback({
          lang: response[0],
        });

        return;
      }
      this.toolbar.querySelector('.jstb_md_foreign').focus();
    });
  },
};
dotclear.ToolBar.prototype.elements.md_foreign.fn.markdown = async function () {
  await this.elements.md_foreign.prompt.call(this, (response) => {
    this.encloseSelection(`<i lang="${response.lang}">`, '</i>');
  });
};

// br
dotclear.ToolBar.prototype.elements.md_br = {
  group: 'br',
  type: 'button',
  title: 'Line break',
  fn: {
    markdown() {
      this.encloseSelection('  \n', '');
    },
  },
};

// blockquote
dotclear.ToolBar.prototype.elements.md_blockquote = {
  group: 'block',
  type: 'button',
  title: 'Blockquote',
  fn: {
    markdown() {
      this.encloseSelection('\n', '', (str) => `> ${str.replaceAll('\r', '').replaceAll('\n', '\n> ')}`);
    },
  },
};

// pre
dotclear.ToolBar.prototype.elements.md_pre = {
  group: 'block',
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
dotclear.ToolBar.prototype.elements.md_ul = {
  group: 'block',
  type: 'button',
  title: 'Unordered list',
  fn: {
    markdown() {
      this.encloseSelection('', '', (str) => `* ${str.replaceAll('\r', '').replaceAll('\n', '\n* ')}`);
    },
  },
};

// ol
dotclear.ToolBar.prototype.elements.md_ol = {
  group: 'block',
  type: 'button',
  title: 'Ordered list',
  fn: {
    markdown() {
      this.encloseSelection('', '', (str) => `1. ${str.replaceAll('\r', '').replaceAll('\n', '\n1. ')}`);
    },
  },
};

// details
dotclear.ToolBar.prototype.elements.md_details = {
  group: 'block',
  type: 'button',
  title: 'Details block',
  fn: {},
  title_prompt: 'Summary:',
  default_title: '',
  prompt(default_title = '') {
    return globalThis.prompt(this.elements.md_details.title_prompt, default_title || this.elements.md_details.default_title);
  },
};

dotclear.ToolBar.prototype.elements.md_details.fn.markdown = function () {
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
dotclear.ToolBar.prototype.elements.md_aside = {
  group: 'block',
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

// link
dotclear.ToolBar.prototype.elements.md_link = {
  group: 'link',
  type: 'button',
  title: 'Link',
  key: 'l',
  shortkey_name: 'L',
  fn: {},
  fncall: {},
  data: {},
  popup(args = '') {
    globalThis.the_toolbar = this;

    this.elements.md_link.data = {};

    window.open(
      this.elements.md_link.open_url + args,
      'dc_popup',
      'alwaysRaised=yes,dependent=yes,toolbar=yes,height=420,width=520,menubar=no,resizable=yes,scrollbars=yes,status=no',
    );
  },
};

dotclear.ToolBar.prototype.elements.md_link.fn.markdown = function () {
  this.elements.md_link.popup.call(this);
};

// img
dotclear.ToolBar.prototype.elements.md_img = {
  group: 'media',
  type: 'button',
  title: 'External image',
  fn: {},
  src_prompt: 'Please give image URL:',
  title_prompt: 'Title for this image:',
  default_title: '',
  prompt(default_src = '', default_title = '') {
    let title = default_title || this.elements.md_img.default_title;

    const src = globalThis.prompt(this.elements.md_img.src_prompt, default_src);
    if (!src) {
      return null;
    }

    title = globalThis.prompt(this.elements.md_img.title_prompt, title);
    if (title === null) {
      return null;
    }

    return {
      src: this.stripBaseURL(src),
      title,
    };
  },
};

dotclear.ToolBar.prototype.elements.md_img.fn.markdown = function () {
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
dotclear.ToolBar.prototype.elements.md_img_select = {
  group: 'media',
  type: 'button',
  title: 'Image chooser',
  key: 'm',
  shortkey_name: 'M',
  fn: {},
  fncall: {},
  data: {},
  popup() {
    globalThis.the_toolbar = this;
    this.elements.md_img_select.data = {};

    window.open(
      this.elements.md_img_select.open_url,
      'dc_popup',
      'alwaysRaised=yes,dependent=yes,toolbar=yes,height=500,width=760,menubar=no,resizable=yes,scrollbars=yes,status=no',
    );
  },
};
dotclear.ToolBar.prototype.elements.md_img_select.fn.markdown = function () {
  this.elements.md_img_select.popup.call(this);
};
dotclear.ToolBar.prototype.elements.img_select.fncall.markdown = function () {
  const d = this.elements.img_select.data;
  if (d?.src === undefined) {
    this.textarea.focus();
  } else {
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
  }
};

// MP3 helper
//dotclear.ToolBar.prototype.elements.mp3_insert = { fncall: {}, data: {} };
dotclear.ToolBar.prototype.elements.mp3_insert.fncall.markdown = function () {
  const d = this.elements.mp3_insert.data;
  if (d.player === undefined) {
    return;
  }

  this.encloseSelection('', '', () => `\n${d.player}\n`);
};

// FLV helper
//dotclear.ToolBar.prototype.elements.flv_insert = { fncall: {}, data: {} };
dotclear.ToolBar.prototype.elements.flv_insert.fncall.markdown = function () {
  const d = this.elements.flv_insert.data;
  if (d.player === undefined) {
    return;
  }

  this.encloseSelection('', '', () => `\n${d.player}\n`);
};

/* Posts selector
-------------------------------------------------------- */
dotclear.ToolBar.prototype.elements.md_post_link = {
  group: 'link',
  type: 'button',
  title: 'Link to an entry',
  key: 'e',
  shortkey_name: 'E',
  fn: {},
  data: {},
  popup() {
    globalThis.the_toolbar = this;
    this.elements.link.data = {};

    window.open(
      this.elements.md_post_link.open_url,
      'dc_popup',
      'alwaysRaised=yes,dependent=yes,toolbar=yes,height=500,width=760,menubar=no,resizable=yes,scrollbars=yes,status=no',
    );
  },
};
dotclear.ToolBar.prototype.elements.md_post_link.fn.markdown = function () {
  this.elements.md_post_link.popup.call(this);
};

// Link helper
// Note link.fncall used by md_post_link is also be used by md_link button (see above)
dotclear.ToolBar.prototype.elements.link.fncall.markdown = function () {
  const link = this.elements.link.data;
  if (link?.href !== undefined) {
    let stag = '[';
    const title = link.title ? ` "${link.title}"` : '';
    let etag = `](${link.href}${title})`;

    if (link?.hreflang) {
      etag = `${etag}{hreflang=${link.hreflang}}`;
    }

    if (!globalThis?.getSelection()?.toString()) {
      // Add link URL as link text content
      stag = `${stag}${link.href_title ?? link.href}`;
    }

    this.encloseSelection(stag, etag);
    return;
  }
  this.textarea.focus();
};

/* Footnote helper
-------------------------------------------------------- */
dotclear.ToolBar.prototype.elements.md_footnote = {
  group: 'link',
  type: 'button',
  title: 'Footnote',
  key: 'n',
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

// Preview
dotclear.ToolBar.prototype.elements.md_preview = {
  group: 'editor',
  type: 'button',
  title: 'Preview',
  key: 'p',
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
dotclear.mergeDeep(dotclear.ToolBar.prototype.elements, dotclear.getData('md_editor'));
