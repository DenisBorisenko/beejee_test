import axios from 'axios'
import router from '@/router'
import JsonFormData from 'json-form-data'

export function getValidationErrors(e) {
    const errors = e.response.data
    if (!errors) return {}
    return errors
}


export let instance = axios.create()

export class Requester {
    async post(url, data, config) {
        return await this.handleRequest(instance.post(url, data, config))
    }

    async get(url, config) {
        return await this.handleRequest(instance.get(url, config))
    }

    async delete(url, config) {
        return await this.handleRequest(instance.delete(url, config))
    }

    async patch(url, data, config) {
        return await this.handleRequest(instance.patch(url, data, config))
    }

    async handleRequest(request) {
        try {
            return await request
        } catch (e) {
            if (e.response) {
                if (e.response.status === 401) {
                    router.push({name: 'login'})
                }
            }

            throw e
        }
    }
}

export default new Requester

export function formData(data) {
    return JsonFormData(data, {includeNullValues: true})
}
