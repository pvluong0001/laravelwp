<template>
    <div class="main-table">
        <div class="columns">
            <div class="column is-4 is-offset-8">
                <input class="input" type="text" v-model="formData.s" @keyup.enter="handleSearch" placeholder="Search..."/>
            </div>
        </div>

        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th v-for="(column, index) in columns" :key="index">
                    {{ capitalize(column.name) }}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, dataIndex) in data" :key="dataIndex">
                <td v-for="(column, columnIndex) in columns" :key="`${dataIndex}-${columnIndex}`">
                    {{ item[column.name] }}
                </td>
            </tr>
            <tr v-if="!data.length">
                <td :colspan="columns.length + 1" align="center">No record!</td>
            </tr>
            </tbody>
        </table>

        <div class="loading-area" v-if="loadingData">
            <div class="loader"></div>
        </div>
    </div>
</template>

<script>
const axios = require('axios');
const capitalize = require('lodash/capitalize');

export default {
    name: "List",
    data: () => ({
        columns: [],
        data: [],
        loadingData: false,
        dataPath: '',
        formData: {
            s: ''
        }
    }),
    async mounted() {
        await this.getConfig()
        await this.getData()
    },
    methods: {
        capitalize,
        async getConfig() {
            const configPath = document.querySelector('input[name="config_path"]').value;

            const {data} = await axios.get(configPath);

            if (data) {
                this.columns = data.columns;
            }
        },
        async getData() {
            this.dataPath = document.querySelector('input[name="data_path"]').value;
            this.loadingData = true;

            try {
                const {data} = await axios.post(this.dataPath, {
                    _token: document.querySelector('input[name="csrf_token"]').value,
                    ...this.formData
                });

                if (data) {
                    this.data = data;

                    console.log(this.data)
                }
            } catch (e) {
            } finally {
                this.loadingData = false;
            }
        },
        async handleSearch() {
            await this.getData()
        }
    }
}
</script>

<style scoped>
.main-table {
    position: relative
}

.loading-area {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(188, 181, 181, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.loader {
    border: 4px solid #f3f3f3; /* Light grey */
    border-top: 4px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 30px;
    height: 30px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
