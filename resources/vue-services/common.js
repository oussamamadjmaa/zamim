import { ref } from "vue";


export default function useCommon() {
    const callApi = async ({url, method, data, config, headers, showErrorNotification, showSuccessNotification }) => {
        method = method || 'get';
        headers = headers || {};
        config = config || {};
        data = data || {};
        showErrorNotification = showErrorNotification || true;
        showSuccessNotification = showSuccessNotification || true;

        try {
            let res = await window.axios({
                method,
                url,
                data,
                headers,
                ...config
            });

            if(showSuccessNotification && method.toLowerCase() == "post" && res.data.message) {
                window.toast.success(res.data.message)
            }

            return res;
        } catch (err) {
            if(showErrorNotification && err.response && (err.response.data.message || err.message)) {
                console.log(err);
                window.toast.error(err.response.data.message || err.message)
            }
            return err.response;
        }
    }

    const makeFetchAllRef = () => {
        return ref({
            isProccessing: true,
            response: null,
            list: [],
            search: ''
        })
    }

    const makeFormRef = (defaultData, createUrl, updateUrl= null) => {
        return ref({
            processing:false,
            show:false,
            response: null,
            errors:[],
            data: {...defaultData},
            defaultData: {...defaultData},
            createUrl:  createUrl,
            updateUrl: updateUrl != null ? updateUrl : createUrl,
            update:null,
        })
    }

    const storeForm = async (formRef, fetchAllRef) => {
        const url = (!formRef.value.update) ? formRef.value.createUrl : formRef.value.updateUrl+'/'+formRef.value.update.id

        if(formRef.value.update) {
            formRef.value.data._method = "PUT";
        }

        formRef.value.response = null
        formRef.value.errors = []
        formRef.value.processing = true

        const res = await callApi({url: url, method: 'POST', data: formRef.value.data})

        formRef.value.processing = false
        formRef.value.response = res

        if(res.status == 200) {

            if(!res.data || !res.data.data) return res;
            if(!formRef.value.update) {
                formRef.value.data = formRef.value.defaultData
                if(fetchAllRef && fetchAllRef.value.list) fetchAllRef.value.list.unshift(res.data.data)
            }else {
                if(fetchAllRef && fetchAllRef.value.list) fetchAllRef.value.list = fetchAllRef.value.list.map((teacher) => (teacher.id == formRef.value.update.id) ? res.data.data : teacher)
            }
        }else if(res.status == 422) {
            formRef.value.errors = res.data.errors || []
        }

        return res;
    }

    const fetchAll = async (url = null, fetchAllRef) => {
        url = new URL(url);

        url.searchParams.append('_t', new Date().getTime())

        if(fetchAllRef.value.search) {
            url.searchParams.append('search', fetchAllRef.value.search)
        }

        fetchAllRef.value.isProccessing = true
        const res = fetchAllRef.value.response = await callApi({url:url.href})
        fetchAllRef.value.isProccessing = false

        if(res.status == 200)  fetchAllRef.value.list = res.data.data
    }

    const fetchOne = async (url) => {
        url = new URL(url);
        url.searchParams.append('timestamp', new Date().getTime())
        url = url.href

        const res = await callApi({url:url})

        if(res.status == 200)  return res.data.data;
        return false;
    }

    return {
        callApi, makeFetchAllRef, fetchAll, fetchOne, makeFormRef, storeForm
    }
}
