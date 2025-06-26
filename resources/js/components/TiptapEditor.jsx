import './TiptapEditor.css';
import React, { useCallback } from 'react';
import { useEditor, EditorContent } from '@tiptap/react';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import YouTube from '@tiptap/extension-youtube';
import Highlight from '@tiptap/extension-highlight';
import TextAlign from '@tiptap/extension-text-align';
import Underline from '@tiptap/extension-underline';
import Placeholder from '@tiptap/extension-placeholder';
import { Markdown } from 'tiptap-markdown';
import ImageResize from 'tiptap-extension-resize-image';
import TextStyle from '@tiptap/extension-text-style';
import { Color } from '@tiptap/extension-color';
import axios from 'axios';

const MenuBar = ({ editor }) => {
  if (!editor) {
    return null;
  }

  const addImage = useCallback(() => {
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/jpeg,image/png,image/gif,image/svg+xml,image/webp');
    input.onchange = async () => {
      const file = input.files[0];
      if (!file) return;

      const maxSize = 3 * 1024 * 1024; // 3MB
      if (file.size > maxSize) {
        alert('Ukuran gambar maksimal 3MB.');
        return;
      }

      const formData = new FormData();
      formData.append('image', file);

      try {
        const response = await axios.post('/mentor/modules/upload-image', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        const url = response.data.url;
        if (url) {
          editor.chain().focus().setImage({ src: url }).run();
        }
      } catch (error) {
        console.error('Error uploading image:', error);
        alert('Gagal mengunggah gambar. Pastikan ukuran gambar tidak melebihi 3MB dan formatnya benar.');
      }
    };
    input.click();
  }, [editor]);

  const addYoutubeVideo = useCallback(() => {
    const url = prompt('Enter YouTube URL');

    if (url) {
      editor.commands.setYoutubeVideo({
        src: url,
        width: 640,
        height: 480,
      });
    }
  }, [editor]);

  const setLink = useCallback(() => {
    const previousUrl = editor.getAttributes('link').href;
    const url = window.prompt('URL', previousUrl);

    // cancelled
    if (url === null) {
      return;
    }

    // empty
    if (url === '') {
      editor.chain().focus().extendMarkRange('link').unsetLink().run();

      return;
    }

    // update link
    editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
  }, [editor]);

  return (
    <div className="tiptap-menubar">
      <button
        onClick={() => editor.chain().focus().toggleBold().run()}
        disabled={!editor.can().chain().focus().toggleBold().run()}
        className={editor.isActive('bold') ? 'is-active' : ''}
        title="Bold"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <path d="M14 10h-1.5a2.5 2.5 0 0 1 0-5H18v5"></path>
          <path d="M14 14h-1.5a2.5 2.5 0 0 0 0 5H18v-5"></path>
        </svg>
        <span className="mobile-label">Bold</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleItalic().run()}
        disabled={!editor.can().chain().focus().toggleItalic().run()}
        className={editor.isActive('italic') ? 'is-active' : ''}
        title="Italic"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <line x1="11" y1="5" x2="11" y2="5"></line>
          <path d="M19 5h-7a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7"></path>
          <line x1="13" y1="5" x2="13" y2="5"></line>
          <line x1="5" y1="19" x2="5" y2="19"></line>
        </svg>
        <span className="mobile-label">Italic</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleStrike().run()}
        disabled={!editor.can().chain().focus().toggleStrike().run()}
        className={editor.isActive('strike') ? 'is-active' : ''}
        title="Strike"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <path d="M16 4H8a4 4 0 0 0-4 4v2a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V8a4 4 0 0 0-4-4z"></path>
          <line x1="3" y1="12" x2="21" y2="12"></line>
        </svg>
        <span className="mobile-label">Strike</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleCode().run()}
        disabled={!editor.can().chain().focus().toggleCode().run()}
        className={editor.isActive('code') ? 'is-active' : ''}
        title="Code"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <polyline points="16 18 22 12 16 6"></polyline>
          <polyline points="8 6 2 12 8 18"></polyline>
        </svg>
        <span className="mobile-label">Code</span>
      </button>
      <button onClick={() => editor.chain().focus().unsetAllMarks().run()} title="Clear marks">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <path d="M11 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h12v7"></path>
          <path d="M21 12v3a2 2 0 0 1-2 2H11"></path>
          <path d="M17 19l-2-2-2 2"></path>
          <path d="M19 17l2 2 2-2"></path>
        </svg>
        <span className="mobile-label">Clear Marks</span>
      </button>
      <button onClick={() => editor.chain().focus().clearNodes().run()} title="Clear nodes">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <path d="M10 21h4"></path>
          <path d="M12 17v4"></path>
          <path d="M14 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10"></path>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
        <span className="mobile-label">Clear Nodes</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleHeading({ level: 1 }).run()}
        className={editor.isActive('heading', { level: 1 }) ? 'is-active' : ''}
        title="Heading 1"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <text x="50%" y="60%" dominantBaseline="middle" textAnchor="middle" fontSize="12">H1</text>
        </svg>
        <span className="mobile-label">H1</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleHeading({ level: 2 }).run()}
        className={editor.isActive('heading', { level: 2 }) ? 'is-active' : ''}
        title="Heading 2"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <text x="50%" y="60%" dominantBaseline="middle" textAnchor="middle" fontSize="12">H2</text>
        </svg>
        <span className="mobile-label">H2</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleHeading({ level: 3 }).run()}
        className={editor.isActive('heading', { level: 3 }) ? 'is-active' : ''}
        title="Heading 3"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <text x="50%" y="60%" dominantBaseline="middle" textAnchor="middle" fontSize="12">H3</text>
        </svg>
        <span className="mobile-label">H3</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleHeading({ level: 4 }).run()}
        className={editor.isActive('heading', { level: 4 }) ? 'is-active' : ''}
        title="Heading 4"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <text x="50%" y="60%" dominantBaseline="middle" textAnchor="middle" fontSize="12">H4</text>
        </svg>
        <span className="mobile-label">H4</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleHeading({ level: 5 }).run()}
        className={editor.isActive('heading', { level: 5 }) ? 'is-active' : ''}
        title="Heading 5"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <text x="50%" y="60%" dominantBaseline="middle" textAnchor="middle" fontSize="12">H5</text>
        </svg>
        <span className="mobile-label">H5</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleHeading({ level: 6 }).run()}
        className={editor.isActive('heading', { level: 6 }) ? 'is-active' : ''}
        title="Heading 6"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <text x="50%" y="60%" dominantBaseline="middle" textAnchor="middle" fontSize="12">H6</text>
        </svg>
        <span className="mobile-label">H6</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleBulletList().run()}
        className={editor.isActive('bulletList') ? 'is-active' : ''}
        title="Bullet list"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <line x1="8" y1="6" x2="21" y2="6"></line>
          <line x1="8" y1="12" x2="21" y2="12"></line>
          <line x1="8" y1="18" x2="21" y2="18"></line>
          <line x1="3" y1="6" x2="3.01" y2="6"></line>
          <line x1="3" y1="12" x2="3.01" y2="12"></line>
          <line x1="3" y1="18" x2="3.01" y2="18"></line>
        </svg>
        <span className="mobile-label">Bullet List</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleOrderedList().run()}
        className={editor.isActive('orderedList') ? 'is-active' : ''}
        title="Ordered list"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <line x1="10" y1="6" x2="21" y2="6"></line>
          <line x1="10" y1="12" x2="21" y2="12"></line>
          <line x1="10" y1="18" x2="21" y2="18"></line>
          <path d="M4 6h1a.5.5 0 0 0 .5-.5V3h-2.5"></path>
          <path d="M3.5 10h1.5a.5.5 0 0 1 .5.5v3h-2.5"></path>
          <path d="M4 17h1a.5.5 0 0 0 .5-.5V14h-2.5"></path>
        </svg>
        <span className="mobile-label">Ordered List</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleCodeBlock().run()}
        className={editor.isActive('codeBlock') ? 'is-active' : ''}
        title="Code block"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <polyline points="16 18 22 12 16 6"></polyline>
          <polyline points="8 6 2 12 8 18"></polyline>
          <line x1="4" y1="12" x2="20" y2="12"></line>
        </svg>
        <span className="mobile-label">Code Block</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleBlockquote().run()}
        className={editor.isActive('blockquote') ? 'is-active' : ''}
        title="Blockquote"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <path d="M3 3v5a4 4 0 0 0 4 4h3"></path>
          <path d="M12 12h-3a4 4 0 0 0-4 4v5"></path>
          <path d="M12 12h-3a4 4 0 0 0-4 4v5"></path>
          <path d="M14 12h-3a4 4 0 0 0-4 4v5"></path>
          <path d="M12 3v5a4 4 0 0 0 4 4h3"></path>
        </svg>
        <span className="mobile-label">Blockquote</span>
      </button>
      <button onClick={() => editor.chain().focus().setHorizontalRule().run()} title="Horizontal rule">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <line x1="3" y1="12" x2="21" y2="12"></line>
        </svg>
        <span className="mobile-label">Horizontal Rule</span>
      </button>
      <button onClick={() => editor.chain().focus().setHardBreak().run()} title="Hard break">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <line x1="22" y1="2" x2="11" y2="13"></line>
          <line x1="22" y1="22" x2="11" y2="11"></line>
        </svg>
        <span className="mobile-label">Hard Break</span>
      </button>
      <button
        onClick={() => editor.chain().focus().undo().run()}
        disabled={!editor.can().chain().focus().undo().run()}
        title="Undo"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <polyline points="1 4 1 10 7 10"></polyline>
          <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
        </svg>
        <span className="mobile-label">Undo</span>
      </button>
      <button
        onClick={() => editor.chain().focus().redo().run()}
        disabled={!editor.can().chain().focus().redo().run()}
        title="Redo"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <polyline points="23 4 23 10 17 10"></polyline>
          <path d="M20.49 15a9 9 0 1 1-2.13-9.36L23 10"></path>
        </svg>
        <span className="mobile-label">Redo</span>
      </button>
      <button onClick={setLink} className={editor.isActive('link') ? 'is-active' : ''} title="Set link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07L10 6.07"></path>
          <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07L14 17.93"></path>
        </svg>
        <span className="mobile-label">Set Link</span>
      </button>
      <button onClick={() => editor.chain().focus().unsetLink().run()} disabled={!editor.isActive('link')} title="Unset link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07L10 6.07"></path>
          <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07L14 17.93"></path>
          <line x1="2" y1="2" x2="22" y2="22"></line>
        </svg>
        <span className="mobile-label">Unset Link</span>
      </button>
      <button onClick={addImage} type="button" title="Add image">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
          <circle cx="8.5" cy="8.5" r="1.5"></circle>
          <polyline points="21 15 16 10 5 21"></polyline>
        </svg>
        <span className="mobile-label">Add Image</span>
      </button>
      <button onClick={addYoutubeVideo} title="Add YouTube video">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-1.94C18.84 4 12 4 12 4s-6.84 0-8.6.48a2.78 2.78 0 0 0-1.94 1.94C2 8.16 2 12 2 12s0 3.84.46 5.58a2.78 2.78 0 0 0 1.94 1.94c1.16.32 8.6.48 8.6.48s6.84 0 8.6-.48a2.78 2.78 0 0 0 1.94-1.94C22 15.84 22 12 22 12s0-3.84-.46-5.58z"></path>
          <polygon points="10 8 16 12 10 16 10 8"></polygon>
        </svg>
        <span className="mobile-label">Add YouTube</span>
      </button>
      <button
        onClick={() => editor.chain().focus().toggleHighlight().run()}
        className={editor.isActive('highlight') ? 'is-active' : ''}
        title="Highlight"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <path d="M17.21 10.39L16.27 1.54C16.14 1.23 15.79 1 15.42 1H8.59c-.37 0-.72.23-.85.54L6.79 10.39"></path>
          <path d="M12 12v6"></path>
          <path d="M14 20h-4"></path>
          <path d="M3 21h18"></path>
        </svg>
        <span className="mobile-label">Highlight</span>
      </button>
      <button
        onClick={() => editor.chain().focus().setTextAlign('left').run()}
        className={editor.isActive({ textAlign: 'left' }) ? 'is-active' : ''}
        title="Align left"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="13" y2="6"></line>
          <line x1="3" y1="18" x2="13" y2="18"></line>
        </svg>
        <span className="mobile-label">Align Left</span>
      </button>
      <button
        onClick={() => editor.chain().focus().setTextAlign('center').run()}
        className={editor.isActive({ textAlign: 'center' }) ? 'is-active' : ''}
        title="Align center"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="7" y1="6" x2="17" y2="6"></line>
          <line x1="7" y1="18" x2="17" y2="18"></line>
        </svg>
        <span className="mobile-label">Align Center</span>
      </button>
      <button
        onClick={() => editor.chain().focus().setTextAlign('right').run()}
        className={editor.isActive({ textAlign: 'right' }) ? 'is-active' : ''}
        title="Align right"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="11" y1="6" x2="21" y2="6"></line>
          <line x1="11" y1="18" x2="21" y2="18"></line>
        </svg>
        <span className="mobile-label">Align Right</span>
      </button>
      <button
        onClick={() => editor.chain().focus().setTextAlign('justify').run()}
        className={editor.isActive({ textAlign: 'justify' }) ? 'is-active' : ''}
        title="Justify"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
        <span className="mobile-label">Justify</span>
      </button>
      <button onClick={() => editor.chain().focus().unsetTextAlign().run()} title="Clear alignment">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-4 w-4">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="13" y2="6"></line>
          <line x1="3" y1="18" x2="13" y2="18"></line>
          <line x1="20" y1="4" x2="4" y2="20"></line>
        </svg>
        <span className="mobile-label">Clear Alignment</span>
      </button>
      <input
        type="color"
        onInput={(event) => editor.chain().focus().setColor(event.target.value).run()}
        value={editor.getAttributes('textStyle').color || '#000000'}
        title="Text color"
      />
      <button
        onClick={() => editor.chain().focus().unsetColor().run()}
        className={editor.isActive('textStyle', { color: editor.getAttributes('textStyle').color }) ? 'is-active' : ''}
        title="Clear text color"
      >
        <span className="mobile-label">Clear Color</span>
      </button>
    </div>
  );
};

const TiptapEditor = ({ content, onUpdate }) => {
  const editor = useEditor({
    extensions: [
      StarterKit.configure({
        bulletList: { keepMarks: true, keepAttributes: false },
        orderedList: { keepMarks: true, keepAttributes: false },
        heading: { levels: [1, 2, 3, 4, 5, 6] },
      }),
      Link.configure({
        openOnClick: false,
      }),
      ImageResize,
      YouTube.configure({
        nocookie: false,
        modestbranding: true,
        autoplay: false,
        controls: true,
        allowfullscreen: true,
        progressBarColor: 'white',
      }),
      Highlight,
      TextAlign.configure({
        types: ['heading', 'paragraph'],
      }),
      Underline,
      Placeholder.configure({
        placeholder: 'Tuliskan modul di sini...',
      }),
      Markdown.configure({
        transformPastedText: true,
      }),
      TextStyle,
      Color,
    ],
    content,
    onUpdate: ({ editor }) => {
      onUpdate(editor.getHTML());
    },
  });

  return (
    <div className="tiptap-editor-container">
      <MenuBar editor={editor} />
      <EditorContent editor={editor} className="prose max-w-none" />
    </div>
  );
};

export default TiptapEditor;
