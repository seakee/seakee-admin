import http from "@/utils/http";

export function avatar(avatar) {
    let param = new FormData();
    param.append('avatar', avatar.file);
    return http({
            method : 'post',
            url    : '/files/avatar',
            headers: {'Content-Type': 'multipart/form-data'},
            data   : param
        }
    );
}
