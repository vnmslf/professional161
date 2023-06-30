{"version":3,"file":"ui.uploader.vue.bundle.map.js","names":["this","BX","UI","exports","ui_vue3","ui_uploader_core","main_core","main_core_events","_uploader","babelHelpers","classPrivateFieldLooseKey","_items","_uploaderError","_handleFileAdd","_handleFileRemove","_handleFileStateChange","_handleFileComplete","_handleFileError","_handleError","_handleUploadStart","_handleUploadComplete","VueUploaderAdapter","EventEmitter","constructor","uploaderOptions","super","Object","defineProperty","value","_handleUploadComplete2","_handleUploadStart2","_handleError2","_handleFileError2","_handleFileComplete2","_handleFileStateChange2","_handleFileRemove2","_handleFileAdd2","writable","setEventNamespace","classPrivateFieldLooseBase","ref","shallowRef","options","Type","isPlainObject","assign","userEvents","events","UploaderEvent","FILE_ADD_START","bind","FILE_REMOVE","FILE_STATE_CHANGE","FILE_COMPLETE","FILE_ERROR","ERROR","UPLOAD_START","UPLOAD_COMPLETE","Uploader","subscribeFromOptions","getUploader","getReactiveItems","getUploaderError","getItems","getItem","id","find","item","destroy","event","file","getData","getState","emit","push","position","findIndex","fileInfo","getId","result","splice","error","toJSON","BaseEvent","data","_vueAdapter","_uploaderOptions","_widgetOptions","_vueApp","_rootComponent","VueUploaderWidget","widgetOptions","defineComponent","getAdapter","getVueApp","BitrixVue","createApp","uploaderAdapter","getRootComponent","renderTo","node","isDomNode","mount","VueUploaderComponent","name","props","type","default","items","uploaderError","provide","uploader","adapter","emitter","beforeCreate","hasOwnAdapter","customUploaderOptions","$options","created","unmounted","Vue3","Event"],"sources":["ui.uploader.vue.bundle.js"],"mappings":"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"}