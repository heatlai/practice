INSERT INTO tablename
            (name,
             address,
             tel)
SELECT *
FROM   (SELECT 'Foo',
               'Somewhere',
               '0911') AS tmp
WHERE  NOT EXISTS (SELECT name
                   FROM   tablename
                   WHERE  name = 'Foo')
LIMIT  1;