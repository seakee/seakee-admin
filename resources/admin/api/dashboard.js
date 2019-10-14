import {get} from "@/utils/http";

export function getServer() {
    return get('/dashboards/server')
}

export function getSystem() {
    return get('/dashboards/system')
}
