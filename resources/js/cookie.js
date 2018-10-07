export var getCookie = function(name) {
    const getCookieValues = function(cookie) {
        const cookieArray = cookie.split('=');
        return cookieArray[1].trim();
    };
    const getCookieNames = function(cookie) {
        const cookieArray = cookie.split('=');
        return cookieArray[0].trim();
    };
    const cookies = document.cookie.split(';');
    const cookieValue = cookies.map(getCookieValues)[cookies.map(getCookieNames).indexOf(name)];
    return (cookieValue === undefined) ? null : cookieValue;
};

export var deleteCookie = function(name) {
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
};