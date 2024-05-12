import { method } from "lodash";
import useCommon from "../../../../vue-services/common"

export default function useRadios() {
    ///
    const {callApi, fetchAll, fetchOne, makeFetchAllRef, makeFormRef, storeForm} = useCommon();
    const pageUrl = `${window._app.url}/radios`;

    ///
    const radios = makeFetchAllRef();
    const getRadios = async (url = null) => {
        await fetchAll(url || pageUrl, radios);
    }
    const getRadio = async (radioId) => {
        return await fetchOne(`${pageUrl}/${radioId}`)
    }

    ///
    const radioForm = makeFormRef({students:[]}, pageUrl)
    const storeRadio = async () => {
        await storeForm(radioForm, radios)
    }

    //
    const storeRating = async (url) => {

        radioForm.value.response = null
        radioForm.value.errors = []
        radioForm.value.processing = true
        radioForm.value.process = {}

        const res = await callApi({
            url: url,
            method:'POST',
            data: {...radioForm.value.data, _method:'PUT'},
        });

        radioForm.value.processing = false
        radioForm.value.response = res

        if(res.status == 200) {
            if(!res.data || !res.data.data) return res;
        }else if(res.status == 422) {
            radioForm.value.errors = res.data.errors || []
        }

        return res;
    }

    ///
    const destroyRadio = (radio) => {
        radios.value.list = radios.value.list.filter((dep) => dep != radio)

        callApi({url: pageUrl+ '/' + radio.id, method: 'POST', data: { _method: "DELETE" }})
    }

    return {
        radios, getRadios, getRadio, radioForm, storeRadio, storeRating, destroyRadio, pageUrl
    }
}
