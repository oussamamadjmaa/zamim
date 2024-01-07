import { ref } from "vue";
import useCommon from "../../../vue-services/common";

export default function useNotifications() {
    const {callApi} = useCommon();

    const notifications = ref({
        isProccessing: true,
        response: null,
        data: [],
    });

    const getNotifications = async (url=null) => {
        url = new URL(url ?? window._app.notificationsRoute);
        url.searchParams.append('timestamp', new Date().getTime())
        url = url.href

        notifications.value.isProccessing = true

        const res = notifications.value.response = await callApi({url:url})

        notifications.value.isProccessing = false
        if(res.status == 200)  notifications.value.data = res.data
        return res.data.data;
    }


    const notificationUrl = (notification) => window._app.notificationUrl.replace('notificationId', notification.id)
    const notificationsUrl = window._app.notificationsRoute.replace('stats', '')


    return {
        notifications, getNotifications, notificationUrl, notificationsUrl
    }
}
