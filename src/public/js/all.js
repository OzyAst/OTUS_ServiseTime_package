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
        type: type,
        async: async,
        dataType: datatype,
        url: url,
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
                    console.error(response.data.text);
            }
        } else {
            if (typeof callback == "function")
                callback(response.data);
        }

    })
    .catch(function (data) {
        console.error(data);
        if (typeof data.responseText !== undefined)
            alert(data.responseText);
    });
}
