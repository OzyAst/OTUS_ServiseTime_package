/**
 * Отправка данных на сервер с последующей обработкой ошибок
 *
 * @param type - тип запроса get, post
 * @param url - url запроса
 * @param data - Данные для отправки
 * @param callback - функция обратного вызова или объкт { success:function(){}, error:function(){} }
 * @param datatype - тип ответа от сервера
 * @param async - асинхронный запрос или нет
 */
function ajax(type, url, data, callback, datatype = 'json', async = true) {
    var config = {
        method: type,
        async: async,
        dataType: datatype,
        url: url,
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    };

    if (type.toLowerCase() === "get") {
        config.params = data;
    } else {
        config.data = data;
    }

    axios(config)
        .then(function (response) {
            if (typeof callback == "object") {
                if (response.data.status === 1) {
                    if (typeof callback.success == "function")
                        callback.success(response.data);
                } else if (data.status === 2) {
                    if (typeof callback.success == "function")
                        callback.success(response.data);
                } else {
                    if (typeof callback.error == "function")
                        callback.error(response.data);
                    else
                        Swal.fire({title: 'Error!', text: response.data.message, icon: 'error'})
                }
            } else {
                if (typeof callback == "function")
                    callback(response.data);
            }

        })
        .catch(function (error) {
            var title = "Error!";
            var message = "";

            if (error.response) {
                if (error.response.status === 401) {
                    return error_unauthorized();
                }
                // The request was made and the server responded with a status code
                // that falls out of the range of 2xx
                message = error.response.data.message
                title = 'Error ('+ error.response.status +')! ';
            } else if (error.request) {
                // The request was made but no response was received
                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                // http.ClientRequest in node.js
                console.log(error.request);
            } else {
                // Something happened in setting up the request that triggered an Error
                message = error.message;
            }

            Swal.fire({title: title, text: message, icon: 'error'})
        });
}

/**
 * Ошибка авторизации
 */
function error_unauthorized() {
    Swal.fire({
        title: "Выполните вход",
        text: "Вам необходимо авторизоваться, для выполнения этого действия",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Авторизоваться',
        cancelButtonText: 'Отмена'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'info',
                html: "Сейчас вас перенаправит на страницу авторизации",
                showConfirmButton: false,
            })
            location.href = '/login'
        }
    })
}
