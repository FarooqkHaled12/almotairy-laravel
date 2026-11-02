<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css">
<style>
    .free-rich-editor { min-height: 300px; background: #fff; }
    .free-rich-editor .ql-editor { min-height: 250px; }
    .free-rich-editor--rtl .ql-editor { direction: rtl; text-align: right; }
    .free-rich-editor--ltr .ql-editor { direction: ltr; text-align: left; }
</style>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    (() => {
        const toolbar = [
            [{ header: [2, 3, false] }],
            ['bold', 'italic', 'underline'],
            [{ align: [] }],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['link'],
            ['clean'],
        ];

        document.querySelectorAll('#desc_ar, #desc_en').forEach(textarea => {
            const isArabic = textarea.id === 'desc_ar';
            const editor = document.createElement('div');
            editor.className = `free-rich-editor free-rich-editor--${isArabic ? 'rtl' : 'ltr'}`;
            textarea.insertAdjacentElement('afterend', editor);
            textarea.hidden = true;

            const quill = new Quill(editor, {
                theme: 'snow',
                modules: { toolbar },
            });

            quill.root.dir = isArabic ? 'rtl' : 'ltr';
            quill.root.style.textAlign = isArabic ? 'right' : 'left';
            if (textarea.value.trim()) {
                quill.clipboard.dangerouslyPasteHTML(textarea.value);
            }

            textarea.form?.addEventListener('submit', () => {
                textarea.value = quill.getSemanticHTML();
            });
        });
    })();
</script>
