import useCommon from "../../../../vue-services/common"

export default function useStudents() {
    ///
    const {callApi, fetchAll, fetchOne, makeFetchAllRef, makeFormRef, storeForm} = useCommon();
    const pageUrl = `${window._app.url}/students`;

    ///
    const students = makeFetchAllRef();
    const getStudents = async (url = null) => {
        await fetchAll(url ?? pageUrl, students);
    }
    const getStudent = async (studentId) => {
        return await fetchOne(`${pageUrl}/${studentId}`)
    }

    ///
    const studentForm = makeFormRef({profile:{}}, pageUrl)
    const storeStudent = async () => {
        await storeForm(studentForm, students)
    }

    ///
    const destroyStudent = (student) => {
        students.value.list = students.value.list.filter((dep) => dep != student)
        callApi({url: pageUrl+ '/' + student.id, method: 'POST', data: { _method: "DELETE" }})
    }

    return {
        students, getStudents, getStudent, studentForm, storeStudent, destroyStudent, pageUrl
    }
}
