SELECT DISTINCT
    L.level_id AS level_id,
    L.level_label AS level_label,
    L.sub_lebel AS sub_lebel,
    L.type AS TYPE,
    L.set_lebel AS set_lebel,
    score.score_des AS score_des,
    score.point AS POINT,
    aprove_list_score.status AS
STATUS
    ,
    aprove_list_score.aprove_id AS app_id,
    aprove_list_score.aprove_date AS aprove_date,
    aprove_list_score.remark AS remark
FROM TRANSACTION
    T,
    LIST
LEFT JOIN score ON LIST
    .score_id = score.score_id,
    LEVEL L
LEFT JOIN aprove_list_score ON L.level_id = aprove_list_score.level_id
WHERE
    TRIM(T.list_id) = TRIM(LIST.list_id) AND TRIM(LIST.level_id) = TRIM(L.level_id) AND T.user_id = 3 AND L.set_lebel = "Guidelines" AND LOWER(TRIM(T.status)) IN("consider", "pass", "reject")
UNION
SELECT DISTINCT
    L.level_id AS level_id,
    L.level_label AS level_label,
    L.sub_lebel AS sub_lebel,
    L.type AS TYPE,
    L.set_lebel AS set_lebel,
    score.score_des AS score_des,
    score.point AS POINT,
    aprove_list_score.status AS
STATUS
    ,
    aprove_list_score.aprove_id AS app_id,
    aprove_list_score.aprove_date AS aprove_date,
    aprove_list_score.remark AS remark
FROM
    user_add
LEFT JOIN score ON user_add.score_id = score.score_id,
    LEVEL L
LEFT JOIN aprove_list_score ON aprove_list_score.level_id = L.level_id
WHERE
    TRIM(L.level_id) = TRIM(user_add.level_id) AND user_add.user_id = 3 AND L.set_lebel = "Guidelines" AND LOWER(TRIM(user_add.status)) IN("consider", "pass", "reject")
ORDER BY
    level_label,
    set_lebel,
    level_id