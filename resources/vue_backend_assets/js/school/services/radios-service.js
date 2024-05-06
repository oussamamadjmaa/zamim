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

    ///
    const destroyRadio = (radio) => {
        radios.value.list = radios.value.list.filter((dep) => dep != radio)

        callApi({url: pageUrl+ '/' + radio.id, method: 'POST', data: { _method: "DELETE" }})
    }

    return {
        radios, getRadios, getRadio, radioForm, storeRadio, destroyRadio, pageUrl
    }
}
