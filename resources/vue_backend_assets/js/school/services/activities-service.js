import useCommon from "../../../../vue-services/common"

export default function useActivities() {
    ///
    const {callApi, fetchAll, fetchOne, makeFetchAllRef, makeFormRef, storeForm} = useCommon();
    const pageUrl = `${window._app.url}/activities`;

    ///
    const activities = makeFetchAllRef();
    const getActivities = async (url = null) => {
        await fetchAll(url ?? pageUrl, activities);
    }
    const getActivity = async (activityId) => {
        return await fetchOne(`${pageUrl}/${activityId}`)
    }

    ///
    const activityForm = makeFormRef({students:{}}, pageUrl)
    const storeActivity = async () => {
        await storeForm(activityForm, activities)
    }

    ///
    const destroyActivity = (activity) => {
        activities.value.list = activities.value.list.filter((dep) => dep != activity)
        callApi({url: pageUrl+ '/' + activity.id, method: 'POST', data: { _method: "DELETE" }})
    }

    return {
        activities, getActivities, getActivity, activityForm, storeActivity, destroyActivity, pageUrl
    }
}
