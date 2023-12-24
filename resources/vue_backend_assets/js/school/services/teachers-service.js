import useCommon from "../../../../vue-services/common"

export default function useTeachers() {
    ///
    const {callApi, fetchAll, fetchOne, makeFetchAllRef, makeFormRef, storeForm} = useCommon();
    const pageUrl = `${window._app.url}/teachers`;

    ///
    const teachers = makeFetchAllRef();
    const getTeachers = async (url = null) => {
        await fetchAll(url ?? pageUrl, teachers);
    }
    const getTeacher = async (teacherId) => {
        return await fetchOne(`${pageUrl}/${teacherId}`)
    }

    ///
    const teacherForm = makeFormRef({profile:{}}, pageUrl)
    const storeTeacher = async () => {
        await storeForm(teacherForm, teachers)
    }

    ///
    const destroyTeacher = (teacher) => {
        teachers.value.list = teachers.value.list.filter((dep) => dep != teacher)
        callApi({url: pageUrl+ '/' + teacher.id, method: 'POST', data: { _method: "DELETE" }})
    }

    return {
        teachers, getTeachers, getTeacher, teacherForm, storeTeacher, destroyTeacher, pageUrl
    }
}
