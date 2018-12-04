<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <input
            :id="field.name"
            class="hidden"
            type="text"
            :name="field.name"
            v-model="value"
            >
            <input
                class="hidden"
                type="file"
                ref="add_file"
                @change="fileSelected"
            />
            <button
                type="button"
                class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded"
                @click="$refs.add_file.click()"
            >Upload File</button>
            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
            <div class="flex flex-wrap pt-8 text-center">
                <div v-for="(file, index) in files" class="w-1/2 p-2 mb-4">
                    <div class="rounded shadow-lg pt-4 m-5 pb-4">
                        <a class="overflow-hidden block text-center" :href="file.url" target="blank">
                            {{ file.name }}
                        </a><br/>
                        <a v-bind:href="file.url" target="blank">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path class="heroicon-ui" d="M6 2h9a1 1 0 0 1 .7.3l4 4a1 1 0 0 1 .3.7v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2zm9 2.41V7h2.59L15 4.41zM18 9h-3a2 2 0 0 1-2-2V4H6v16h12V9zm-2 7a1 1 0 0 1-1 1H9a1 1 0 0 1 0-2h6a1 1 0 0 1 1 1zm0-4a1 1 0 0 1-1 1H9a1 1 0 0 1 0-2h6a1 1 0 0 1 1 1zm-5-4a1 1 0 0 1-1 1H9a1 1 0 1 1 0-2h1a1 1 0 0 1 1 1z"/>
                            </svg>
                        </a>&nbsp;
                        <a href="#" @click.prevent="deleteFile(index)" class="text-danger hover:font-bold no-underline mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data() {
        return {
            selectedFile: null,
            files: [],
        }
    },

    methods: {
        /**
         * Selected file event trigger
         */
        fileSelected(event) {
            var app = this
            const fd = new FormData()
            fd.append('file', event.target.files[0], event.target.files[0].name)

            axios.post('/nova-vendor/array-files/upload', fd)
                .then(res => {
                    app.files.push(res.data)
                    app.value = JSON.stringify(app.files)
                })
        },

        deleteFile(index) {
            axios.delete('/nova-vendor/array-files/delete/'+this.files[index].name)
            this.files.splice(index, 1)
            this.value = JSON.stringify(this.files)
        },

        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
            this.files = JSON.parse(this.field.value) || []
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value
        },
    },
}
</script>
