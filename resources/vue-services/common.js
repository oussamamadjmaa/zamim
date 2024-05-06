import { ref } from "vue";

export default function useCommon() {
    const callApi = async ({url, method = 'get', data = {}, config = {}, headers = {}, showErrorNotification= true, showSuccessNotification = true }) => {
        try {
            let res = await window.axios({
                method,
                url,
                data,
                headers,
                ...config
            });

            if (showSuccessNotification && method.toLowerCase() === 'post' && res.data && res.data.message) {
                window.toast.success(res.data.message);
            }

            return res;
        } catch (err) {
            let errorMessage = err.response?.data?.message || err.message;
            if (errorMessage == 'Unauthenticated.') {
                window.location.href = `${window._app.url}/login?unauthenticated=true`;
            }
            if(showErrorNotification && errorMessage) {
                window.toast.error(errorMessage)
            }
            return err.response;
        }
    }

    const makeFetchAllRef = () => {
        return ref({
            isProccessing: false,
            response: null,
            list: [],
            search: '',
            dataType: 'default',
            withoutPagination: false,
            extraParams: {}
        })
    }

    const makeFormRef = (defaultData = {}, createUrl = '', updateUrl = null) => {
        return ref({
            processing:false,
            show:false,
            response: null,
            errors:[],
            data: JSON.parse(JSON.stringify(defaultData)),
            defaultData: JSON.parse(JSON.stringify(defaultData)),
            createUrl:  createUrl,
            updateUrl: updateUrl != null ? updateUrl : createUrl,
            update:null,
        })
    }

    const storeForm = async (formRef, fetchAllRef, {config = {}, headers = {}, successCallback = false} = {}) => {
        const url = (!formRef.value.update) ? formRef.value.createUrl : formRef.value.updateUrl+'/'+formRef.value.update.id

        if(formRef.value.update) {
            formRef.value.data._method = "PUT";
        }

        formRef.value.response = null
        formRef.value.errors = []
        formRef.value.processing = true
        formRef.value.process = {}

        const res = await callApi({
            url: url,
            method: 'POST',
            data: formRef.value.data,
            headers:headers,
            config: {
                onUploadProgress: (progressEvent) => {
                    const { loaded, total } = progressEvent;
                    let percent = Math.floor((loaded * 100) / total);
                    formRef.value.process = {
                        loaded, total, percent
                    }
                },
                ...config
            }
        })

        formRef.value.processing = false
        formRef.value.response = res

        if(res.status == 200) {
            if (successCallback && typeof successCallback == 'function') {
                return successCallback(res);
            }
            if(!res.data || !res.data.data) return res;
            if(!formRef.value.update) {
                formRef.value.data = formRef.value.defaultData
                if(fetchAllRef && fetchAllRef.value.list) fetchAllRef.value.list.unshift(res.data.data)
            }else {
                if(fetchAllRef && fetchAllRef.value.list) fetchAllRef.value.list = fetchAllRef.value.list.map((listItem) => (listItem.id == formRef.value.update.id) ? res.data.data : listItem)
            }
        }else if(res.status == 422) {
            formRef.value.errors = res.data.errors || []
        }

        return res;
    }

    const fetchAll = async (url, fetchAllRef) => {
        url = new URL(url);

        appendSearchParams(url, '_t', new Date().getTime());
        appendSearchParams(url, 'search', fetchAllRef.value.search);
        appendSearchParams(url, 'dataType', fetchAllRef.value.dataType);
        appendSearchParams(url, 'withoutPagination', fetchAllRef.value.withoutPagination);

        let { extraParams } = fetchAllRef.value;

        let paramsKeys = Object.keys(extraParams);

        if (paramsKeys.length) {
            paramsKeys.forEach(function(param) {
                let value = extraParams[param];
                appendSearchParams(url, param, value);
            });
        }

        fetchAllRef.value.isProccessing = true

        const res = await callApi({ url: url.href });
        fetchAllRef.value.response = res;
        fetchAllRef.value.isProccessing = false;

        if (res.status === 200) {
            fetchAllRef.value.list = res.data.data;
        }else {
            console.error('Error fetching data:', error);
        }
    }

    const fetchOne = async (url) => {
        url = new URL(url);
        url.searchParams.append('timestamp', new Date().getTime())
        url = url.href

        const res = await callApi({url:url})

        if (res.status === 200) {
            return res.data.data;
        }else{
            console.error('Error fetching data:', error);
        }
    }

    const appendSearchParams = (url, paramName, paramValue) => {
        if (paramValue) {
            url.searchParams.append(paramName, paramValue);
        }
    };

    return {
        callApi, makeFetchAllRef, fetchAll, fetchOne, makeFormRef, storeForm
    }
}
