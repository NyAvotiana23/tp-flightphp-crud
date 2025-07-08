//const apiBase = "http://localhost/finance/tp-flightphp-crud/ws";
// const apiBase = "http://localhost/tp-flightphp-crud/ws";
const apiBase = "http://localhost/Tp%20Final%20S4/tp-flightphp-crud/ws";

// AJAX function (provided by user)
function ajax(method, url, data, callback, errorCallback) {
    const xhr = new XMLHttpRequest();
    const fullUrl = apiBase + url;

    xhr.open(method, fullUrl, true);

    if (method === 'POST' || method === 'PUT') {
        xhr.setRequestHeader("Content-Type", "application/json");
    } else {
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    }

    xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    callback(response);
                } catch (e) {
                    console.error("Error parsing response:", e);
                    if (errorCallback) errorCallback("Invalid JSON response from server");
                }
            } else {
                console.error(`Request failed with status ${xhr.status}: ${xhr.statusText}`);
                if (errorCallback) errorCallback(`Request failed with status ${xhr.status}: ${xhr.statusText}`);
            }
        }
    };

    xhr.onerror = () => {
        console.error("Network error occurred");
        if (errorCallback) errorCallback("Network error occurred");
    };

    let requestData = null;
    if (data) {
        if (method === 'POST' || method === 'PUT') {
            requestData = JSON.stringify(data);
        } else if (method === 'GET' || method === 'DELETE') {
            const params = new URLSearchParams(data).toString();
            xhr.open(method, fullUrl + (params ? `?${params}` : ''), true);
        }
    }

    xhr.send(requestData);
}
