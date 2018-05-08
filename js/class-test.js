var Polygon = class User
{
    constructor(userId)
    {
        this._userId = userId;
    }

    get id()
    {
        return this._userId;
    }

    names()
    {
        let _name;

        this.getName = () =>
        {
            return _name;
        };

        this.setName = (name) =>
        {
            _name = name;
            return _name;
        };
    }
};

var objects = [
    {
        get a b() {
            return 1
        }
    },
    {
        a getter:function b() {return 1}
    },
    {
        "a"
        getter:function b() {return 1}
    }
];

