import api, {formData} from '@/api'

export default class TaskRequester {

    static index(payload) {
        return api.get('/task', {params: payload})
    }

    static store(payload) {
        return api.post('/task/store', formData(payload))
    }

    static update(payload) {
        return api.post('/task/update', formData(payload))
    }

}
