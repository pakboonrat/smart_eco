SELECT  DISTINCT L.level_id      AS level_id 
       ,L.level_label            AS level_label 
       ,L.sub_lebel              AS sub_lebel 
       ,L.type                   AS type 
       ,L.set_lebel              AS set_lebel 
       ,score.score_des          AS score_des 
       ,score.point              AS point 
       ,aprove_list_score.status AS status
       ,aprove_list_score.
FROM transaction T ,list
LEFT JOIN score
ON list.score_id = score.score_id , level L
LEFT JOIN aprove_list_score
ON L.level_id = aprove_list_score.level_id
WHERE TRIM(T.list_id) = trim(list.list_id) 
AND trim(list.level_id) = trim(L.level_id) 
AND T.user_id = 3 
AND L.set_lebel = "Guidelines" 
AND LOWER(TRIM(T.status)) IN ("consider","pass","reject") 

UNION 
SELECT  DISTINCT L.level_id      AS level_id 
       ,L.level_label            AS level_label 
       ,L.sub_lebel              AS sub_lebel 
       ,L.type                   AS type 
       ,L.set_lebel              AS set_lebel 
       ,score.score_des          AS score_des 
       ,score.point              AS point 
       ,aprove_list_score.status AS status
FROM user_add
LEFT JOIN score
ON user_add.score_id = score.score_id , level L
LEFT JOIN aprove_list_score
ON aprove_list_score.level_id = L.level_id
WHERE trim(L.level_id) = trim(user_add.level_id) 
AND user_add.user_id = 3 
AND L.set_lebel = "Guidelines" 
AND LOWER(TRIM(user_add.status)) IN ("consider","pass","reject")
ORDER BY level_label , set_lebel,level_id 