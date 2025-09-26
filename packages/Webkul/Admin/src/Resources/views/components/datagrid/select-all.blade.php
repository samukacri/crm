<label class="inline-flex cursor-pointer items-center">
    <input
        type="checkbox"
        class="h-4 w-4 cursor-pointer rounded border border-gray-300 bg-white text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:checked:bg-blue-600 dark:focus:ring-blue-600"
        :checked="isAllSelected"
        @change="selectAll"
    />
</label>