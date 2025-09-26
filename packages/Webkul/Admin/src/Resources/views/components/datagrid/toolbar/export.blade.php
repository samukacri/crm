<div class="flex items-center gap-x-1">
    <button
        type="button"
        class="inline-flex w-full max-w-max cursor-pointer appearance-none items-center justify-between gap-x-2 rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-center text-sm font-semibold text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"
        @click="$emitter.emit('open-export-modal')"
    >
        <i class="icon-export text-2xl"></i>

        @lang('admin::app.datagrid.toolbar.export.title')
    </button>
</div>