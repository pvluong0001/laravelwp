if(!window.hasOwnProperty('ListStandardPlugin')) {
    const axios = require('axios');

    window.ListStandardPlugin = ((api) => {
        async function fetchData() {
            const dataPath = document.querySelector('input[name="data_path"]').value;

            const {data} = await api.post(dataPath, {
                _token: document.querySelector('input[name="csrf_token"]').value,
                ...this.formData
            });

            data && draw(data);
        }

        function draw(htmlData, querySelector = '#render-box') {
            const element = document.querySelector(querySelector);

            element.innerHTML = htmlData;
        }

        return {
            fetchData
        }
    })(axios);
}