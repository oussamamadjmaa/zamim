import useCommon from "../../../../vue-services/common"

export default function useRadioWeeks() {
    ///
    const {callApi, fetchAll, fetchOne, makeFetchAllRef, makeFormRef, storeForm} = useCommon();
    const pageUrl = `${window._app.url}/radio-weeks`;

    ///
    const radioWeeks = makeFetchAllRef();
    const getRadioWeeks = async (url = null) => {
        await fetchAll(url ?? pageUrl, radioWeeks);
    }
    const getRadioWeek = async (radioWeekId) => {
        return await fetchOne(`${pageUrl}/${radioWeekId}`)
    }

    ///
    const radioWeekForm = makeFormRef({radios: {Sunday:{}, Monday:{}, Tuesday:{}, Wednesday:{}, Thursday:{}}}, pageUrl)
    const storeRadioWeek = async () => {
        await storeForm(radioWeekForm, radioWeeks)
    }

    ///
    const destroyRadioWeek = (radioWeek) => {
        radioWeeks.value.list = radioWeeks.value.list.filter((dep) => dep != radioWeek)
        callApi({url: pageUrl+ '/' + radioWeek.id, method: 'POST', data: { _method: "DELETE" }})
    }

    return {
        radioWeeks, getRadioWeeks, getRadioWeek, radioWeekForm, storeRadioWeek, destroyRadioWeek, pageUrl
    }
}
