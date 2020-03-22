SELECT
    name,
    SUM(count) as freq
FROM
    baby.baby_names
WHERE
    year < 2010
    AND gender = 'M'
GROUP BY
    name
ORDER BY
    freq DESC