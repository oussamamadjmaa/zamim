import useCommon from "../../../../vue-services/common"

export default function useArticles() {
    ///
    const {callApi, fetchAll, fetchOne, makeFetchAllRef, makeFormRef, storeForm} = useCommon();
    const pageUrl = `${window._app.url}/articles`;

    ///
    const articles = makeFetchAllRef();
    const getArticles = async (url = null) => {
        await fetchAll(url || pageUrl, articles);
    }
    const getArticle = async (articleId) => {
        return await fetchOne(`${pageUrl}/${articleId}`)
    }

    ///
    const articleForm = makeFormRef({}, pageUrl)
    const storeArticle = async () => {
        await storeForm(articleForm, articles)
    }

    ///
    const destroyArticle = (article) => {
        articles.value.list = articles.value.list.filter((dep) => dep != article)
        callApi({url: pageUrl+ '/' + article.id, method: 'POST', data: { _method: "DELETE" }})
    }

    //
    const radios = makeFetchAllRef();
    const getRadios = async (url = null) => {
        await fetchAll(url || `${window._app.url}/articles/get_radios`, radios)
    }

    return {
        articles, getArticles, getArticle, articleForm, storeArticle, destroyArticle, pageUrl, radios, getRadios
    }
}
