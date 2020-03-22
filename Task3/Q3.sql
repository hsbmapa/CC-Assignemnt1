SELECT
    name,
    SUM(count) as freq
FROM
    baby.baby_names
WHERE
    year >= 2000
GROUP BY
    name
ORDER BY
    freq ASC
    LIMIT 10