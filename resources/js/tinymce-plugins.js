tinymce.PluginManager.add('gallery', (editor, url) => {
    editor.ui.registry.addSplitButton('gallery', {
        icon: 'gallery',
        onAction: () => {
            alert('gallery opened');
        },
        onItemAction: (api, value) => editor.execCommand(value),
        fetch: (callback) => {
            const items = [
                {
                    type: 'choiceitem',
                    icon: 'image',
                    text: 'Insert Image',
                    value: 'mceImage'
                },
                {
                    type: 'choiceitem',
                    icon: 'embed',
                    text: 'Insert Media',
                    value: 'mceMedia'
                }
            ];
            callback(items);
        }
    });

    return {
        getMetaData: () => ({
            name: 'Gallery Plugin',
            url: 'https://onebiznet.test',
        })
    };
});