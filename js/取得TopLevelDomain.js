function get_top_domain()
{
    let i, h,
        weird_cookie = 'weird_get_top_level_domain=cookie',
        hostname = document.location.hostname.split('.');
    for (i = hostname.length - 1; i >= 0; i--)
    {
        h = hostname.slice(i).join('.');
        document.cookie = weird_cookie + ';domain=.' + h + ';';
        if (document.cookie.indexOf(weird_cookie) > -1)
        {
            document.cookie = weird_cookie.split('=')[0] + '=;domain=.' + h + ';expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            return h;
        }
    }
}