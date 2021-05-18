SELECT U1.user_id as USER , U1.firstname as firstname,  LV.level_label  as level_label , GROUP_CONCAT(distinct LV.level_label ) AS G_level_label,
  GROUP_CONCAT(distinct T1.firstname ) AS AUDIT , 
  GROUP_CONCAT(distinct T6.firstname ) AS AUDIT_ALL , T1.status as status
  FROM level LV, user U1
  LEFT JOIN 
  (SELECT DISTINCT  T3.user_id as user_id ,
    CASE  
    WHEN T3.user_id = aprove_list_score.user_id AND T3.status in ('pass') AND A3.firstname is NULL AND aprove_list_score.status = 'pass' THEN 2 
    WHEN T3.user_id = aprove_list_score.user_id AND T3.status in ('pass') AND A3.firstname is NOT NULL AND aprove_list_score.status = 'pass' THEN 2 
    WHEN T3.user_id = aprove_list_score.user_id AND T3.status in ('consider','pass','reject') AND aprove_list_score.status != 'pass' AND aprove_list_score.level_id = L.level_id THEN 1 
    WHEN T3.status in ('consider','pass','reject') AND aprove_list_score.user_id is NULL AND aprove_list_score.status is NULL THEN 1
    WHEN T3.status in ('consider','pass','reject') 
     AND T3.user_id not in ( SELECT A4.user_id 
                               	from  aprove_list_score A4  
                				WHERE A4.user_id = T3.user_id AND A4.level_id = L.level_id 
                               		AND  A4.status = 'pass' ) THEN 1
     WHEN T3.user_id != aprove_list_score.user_id THEN 0
     ELSE 0 END AS status , A3.firstname as firstname , L.level_id as LEVEL
    FROM list L , transaction  T3 
     LEFT JOIN 
      (select DISTINCT aprove.t_id,user.firstname 
       FROM aprove,user 
       where aprove.audit_id=user.user_id ) A3 ON T3.t_id=A3.t_id
     LEFT JOIN aprove_list_score on T3.user_id = aprove_list_score.user_id 
     WHERE T3.list_id = L.list_id
                    
 UNION 
  SELECT DISTINCT A4.user_id as user_id ,
   CASE  
    WHEN  A4.status='pass' THEN 2
    ELSE 0 END AS status , U4.firstname as firstname , A4.level_id as LEVEL
  FROM aprove_list_score A4 ,user U4 
  WHERE A4.audit_id = U4.user_id

 UNION
  SELECT DISTINCT UADD3.user_id as user_id ,
   CASE  
    WHEN  UADD3.user_id = aprove_list_score.user_id  AND UADD3.status in ('pass') AND UA3.firstname is null AND aprove_list_score.status = 'pass' THEN 2
    WHEN  UADD3.user_id = aprove_list_score.user_id  AND UADD3.status in ('pass') AND UA3.firstname is not null AND aprove_list_score.status = 'pass' THEN 2
    WHEN  UADD3.user_id = aprove_list_score.user_id  AND UADD3.status in  ('consider','pass','reject') AND  aprove_list_score.status != 'pass' THEN 1
    WHEN  UADD3.status in  ('consider','pass','reject') AND aprove_list_score.user_id is NULL THEN 1
    WHEN  UADD3.status in ('consider','pass','reject') AND ( ( aprove_list_score.user_id is NULL ) OR ( UADD3.user_id != aprove_list_score.user_id )) THEN 1
    WHEN  UADD3.user_id != aprove_list_score.user_id THEN 0 ELSE 0 END AS status ,  UA3.firstname as firstname , UADD3.level_id as LEVEL
  FROM user_add  UADD3 
  LEFT JOIN 
  ( 	select DISTINCT aprove_user_add.add_id,user.firstname 
  		FROM aprove_user_add,user 
  		where aprove_user_add.audit_id=user.user_id 
					) UA3 ON UADD3.add_id=UA3.add_id 
  LEFT JOIN aprove_list_score on UADD3.level_id = aprove_list_score.level_id
  , list 
                ) T1 ON U1.user_id=T1.user_id
                
                LEFT JOIN 
                (   
                    SELECT DISTINCT  T6.user_id as user_id , U6.firstname as firstname 
                    FROM transaction  T6 , aprove A6 , user U6
                    WHERE T6.t_id=A6.t_id AND A6.audit_id=U6.user_id
                    
                    UNION
                    SELECT DISTINCT UD6.user_id as user_id ,  user6.firstname as firstname 
					FROM user_add  UD6 , aprove_user_add AP6 , user user6
					WHERE UD6.add_id=AP6.add_id AND AP6.audit_id=user6.user_id 
                    
                    UNION
                    SELECT DISTINCT AL6.user_id as user_id , ALU6.firstname as firstname 
                    FROM aprove_list_score AL6 , user ALU6 
                    WHERE AL6.audit_id=ALU6.user_id 
                ) T6 on U1.user_id=T6.user_id
 

                WHERE U1.user_type = 'USER' AND T1.LEVEL=LV.level_id
                 
                GROUP BY USER ORDER BY status ASC,firstname ASC