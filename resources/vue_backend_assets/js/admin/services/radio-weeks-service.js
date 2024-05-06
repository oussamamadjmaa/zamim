import useCommon from "../../../../vue-services/common"

export default function useRadioWeeks() {
    ///
    const {callApi, fetchAll, fetchOne, makeFetchAllRef, makeFormRef, storeForm} = useCommon();
    const pageUrl = `${window._app.url}/radio-weeks`;

    ///
    const radioWeeks = makeFetchAllRef();
    const getRadioWeeks = async (url = null) => {
        await fetchAll(url || pageUrl, radioWeeks);
    }
    const getRadioWeek = async (semesterId, level, weekNumber) => {
        return await fetchOne(`${pageUrl}/get?semester_id=${semesterId}&level=${level}&week_number=${weekNumber}`)
    }

    ///
    const radioWeekForm = makeFormRef({radios: {Sunday:{}, Monday:{}, Tuesday:{}, Wednesday:{}, Thursday:{}}}, pageUrl)
    const storeRadioWeek = async () => {
        await storeForm(radioWeekForm, radioWeeks, {successCallback: function(res) {
            getRadioWeeks()
        }})
    }

    ///
    const destroyRadioWeek = (radioWeek) => {
        radioWeeks.value.list = radioWeeks.value.list.filter((dep) => dep != radioWeek)
        callApi({url: pageUrl+ `?semester_id=${radioWeek.semesterId}&level=${radioWeek.level}&week_number=${radioWeek.weekNumberEn}`, method: 'POST', data: { _method: "DELETE" }})
    }

    return {
        radioWeeks, getRadioWeeks, getRadioWeek, radioWeekForm, storeRadioWeek, destroyRadioWeek, pageUrl
    }
}
