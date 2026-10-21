<script src="https://cdn.tiny.cloud/1/{{ rawurlencode(config('services.tinymce.key', 'no-api-key')) }}/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
    tinymce.init({
        selector: '#desc_ar, #desc_en',
        plugins: [
            'accordion', 'advlist', 'anchor', 'autolink', 'autoresize', 'autosave',
            'charmap', 'code', 'codesample', 'directionality', 'emoticons', 'fullscreen',
            'help', 'image', 'importcss', 'insertdatetime', 'link', 'lists', 'media',
            'nonbreaking', 'pagebreak', 'preview', 'quickbars', 'save', 'searchreplace',
            'table', 'visualblocks', 'visualchars', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | bold italic underline | align | bullist numlist | link image media | table | code',
        height: 300,
        language: 'ar',
        directionality: 'rtl',
        menubar: false
    });
</script>
