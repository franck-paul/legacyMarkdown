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
    h6: 'Header 6'
  },
  markdown: {
    list: ['nonebis','h3','h4','h5'],
    fn: function(opt) {
      switch (opt) {
        case 'nonebis': this.textarea.focus(); break;
        case 'h3': this.encloseSelection('### '); break;
        case 'h4': this.encloseSelection('#### '); break;
        case 'h5': this.encloseSelection('##### '); break;
      }
      this.toolNodes.blocks.value = 'nonebis';
    }
  }
};

// spacer
jsToolBar.prototype.elements.md_space0 = {
  type:'space',
  format:{
    markdown:true
  }
};

// strong
jsToolBar.prototype.elements.md_strong = {
  type: 'button',
  title: 'Strong emphasis',
  icon: 'style/jsToolBar/bt_strong.png',
  fn: {
    markdown: function() { this.singleTag('**') }
  }
};

// em
jsToolBar.prototype.elements.md_em = {
  type: 'button',
  title: 'Emphasis',
  icon: 'style/jsToolBar/bt_em.png',
  fn: {
    markdown: function() { this.singleTag('*') }
  }
};

// ins
jsToolBar.prototype.elements.md_ins = {
  type: 'button',
  title: 'Inserted',
  icon: 'style/jsToolBar/bt_ins.png',
  fn: {
    markdown: function() { this.singleTag('<ins>','</ins>') }
  }
};

// del
jsToolBar.prototype.elements.md_del = {
  type: 'button',
  title: 'Deleted',
  icon: 'style/jsToolBar/bt_del.png',
  fn: {
    markdown: function() { this.singleTag('<del>','</del>') }
  }
};

// quote
jsToolBar.prototype.elements.md_quote = {
  type: 'button',
  title: 'Inline quote',
  icon: 'style/jsToolBar/bt_quote.png',
  fn: {
    markdown: function() { this.singleTag('<q>','</q>') }
  }
};

// code
jsToolBar.prototype.elements.md_code = {
  type: 'button',
  title: 'Code',
  icon: 'style/jsToolBar/bt_code.png',
  fn: {
    markdown: function() { this.singleTag('`') }
  }
};

// spacer
jsToolBar.prototype.elements.md_space1 = {
  type:'space',
  format:{
    markdown:true
  }
};

// br
jsToolBar.prototype.elements.md_br = {
  type: 'button',
  title: 'Line break',
  icon: 'style/jsToolBar/bt_br.png',
  fn: {
    markdown: function() { this.encloseSelection("  \n",'') }
  }
};

// spacer
jsToolBar.prototype.elements.md_space2 = {
  type:'space',
  format:{
    markdown:true
  }
};

// blockquote
jsToolBar.prototype.elements.md_blockquote = {
  type: 'button',
  title: 'Blockquote',
  icon: 'style/jsToolBar/bt_bquote.png',
  fn: {
    markdown: function() {
      this.encloseSelection("\n",'',
      function(str) {
        str = str.replace(/\r/g,'');
        return '> '+str.replace(/\n/g,"\n> ");
      });
    }
  }
};

// pre
jsToolBar.prototype.elements.md_pre = {
  type: 'button',
  title: 'Preformated text',
  icon: 'style/jsToolBar/bt_pre.png',
  fn: {
    markdown: function() {
      this.encloseSelection("\n",'',
      function(str) {
        str = str.replace(/\r/g,'');
        return '    '+str.replace(/\n/g,"\n    ");
      });
    }
  }
};

// ul
jsToolBar.prototype.elements.md_ul = {
  type: 'button',
  title: 'Unordered list',
  icon: 'style/jsToolBar/bt_ul.png',
  fn: {
    markdown: function() {
      this.encloseSelection('','',function(str) {
        str = str.replace(/\r/g,'');
        return '* '+str.replace(/\n/g,"\n* ");
      });
    }
  }
};

// ol
jsToolBar.prototype.elements.md_ol = {
  type: 'button',
  title: 'Ordered list',
  icon: 'style/jsToolBar/bt_ol.png',
  fn: {
    markdown: function() {
      this.encloseSelection('','',function(str) {
        str = str.replace(/\r/g,'');
        return '1. '+str.replace(/\n/g,"\n1. ");
      });
    }
  }
};

// spacer
jsToolBar.prototype.elements.md_space3 = {
  type:'space',
  format:{
    markdown:true
  }
};

// link
jsToolBar.prototype.elements.md_link = {
  type: 'button',
  title: 'Link',
  icon: 'style/jsToolBar/bt_link.png',
  fn: {},
  href_prompt: 'Please give URL:',
  title_prompt: 'Title for this URL:',
  default_title: '',
  prompt: function(href,title) {
    href = href || '';
    title = title || this.elements.md_link.default_title;
    
    href = window.prompt(this.elements.md_link.href_prompt,href);
    if (!href) { return false; }
    
    title = window.prompt(this.elements.md_link.title_prompt,title);
    
    return { href: this.stripBaseURL(href), title: title };
  }
};

jsToolBar.prototype.elements.md_link.fn.markdown = function() {
  var link = this.elements.md_link.prompt.call(this);
  if (link) {
    var stag = '[';
    var etag = ']('+link.href;
    if (link.title) { etag = etag+' "'+link.title+'"'; }
    etag = etag+')';
    
    this.encloseSelection(stag,etag);
  }
};

// img
jsToolBar.prototype.elements.md_img = {
  type: 'button',
  title: 'External image',
  icon: 'style/jsToolBar/bt_img.png',
  fn: {},
  src_prompt: 'Please give image URL:',
  title_prompt: 'Title for this image:',
  default_title: '',
  prompt: function(src,title) {
    src = src || '';
    title = title || this.elements.md_img.default_title;

    src = window.prompt(this.elements.md_img.src_prompt,src);
    if (!src) { return false; }

    title = window.prompt(this.elements.md_img.title_prompt,title);

    return { src: this.stripBaseURL(src), title: title };
  }
};

jsToolBar.prototype.elements.md_img.fn.markdown = function() {
  var image = this.elements.md_img.prompt.call(this);
  if (image) {
    var stag = '![';
    var etag = ']('+image.src;
    if (image.title) { etag = etag+' "'+image.title+'"'; }
    etag = etag+')';

    this.encloseSelection(stag,etag);
  }
};
