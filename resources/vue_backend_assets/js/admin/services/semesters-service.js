import useCommon from "../../../../vue-services/common"

export default function useSemesters() {
    ///
    const {callApi, fetchAll, fetchOne, makeFetchAllRef, makeFormRef, storeForm} = useCommon();
    const pageUrl = `${window._app.url}/semesters`;

    ///
    const semesters = makeFetchAllRef();
    const getSemesters = async (url = null) => {
        await fetchAll(url || pageUrl, semesters);
    }
    const getSemester = async (semesterId) => {
        return await fetchOne(`${pageUrl}/${semesterId}`)
    }

    ///
    const semesterForm = makeFormRef({}, pageUrl)
    const storeSemester = async () => {
        await storeForm(semesterForm, semesters)
    }

    ///
    const destroySemester = (semester) => {
        semesters.value.list = semesters.value.list.filter((dep) => dep != semester)
        callApi({url: pageUrl+ '/' + semester.id, method: 'POST', data: { _method: "DELETE" }})
    }

    return {
        semesters, getSemesters, getSemester, semesterForm, storeSemester, destroySemester, pageUrl
    }
}
