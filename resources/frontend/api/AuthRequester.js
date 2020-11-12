import api, {formData} from '@/api'

export default class AuthRequester {

    static login(payload) {
        return api.post('/auth/login', formData(payload))
    }

    static logout() {
        return api.get('/auth/logout')
    }

    static user() {
        return api.post('/auth/user')
    }

}
