function getTopLevelDomain()
{
    if( typeof window.topLevelDomain !== 'undefined' )
    {
        return window.topLevelDomain;
    }

    window.topLevelDomain = (function()
    {
        let tryCookie = 'try_get_top_level_domain=cookie';
        let hostname = document.location.hostname.split('.');

        if( hostname.length === 1)
        {
            return hostname[0];
        }

        for (let i = hostname.length - 1; i >= 0; i--)
        {
            let tryingName = hostname.slice(i).join('.');
            document.cookie = tryCookie + ';domain=.' + tryingName + ';';

            if (document.cookie.indexOf(tryCookie) > -1)
            {
                document.cookie = tryCookie.split('=')[0] + '=;domain=.' + tryingName + ';expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                return tryingName;
            }
        }
    })();

    return window.topLevelDomain;
}