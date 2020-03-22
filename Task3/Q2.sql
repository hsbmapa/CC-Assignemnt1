SELECT
    year,
    SUM(count) as freq
FROM
    baby.baby_names
WHERE
    year > 1999
    AND gender = 'F'
    AND name LIKE '%ie%'
GROUP BY
    year
ORDER BY
    freq DESC
LIMIT
    10