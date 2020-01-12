-- レビュテーブルから指定されたレストランIDのレビュを抽出するSQLを作成する。ここで、レストランIDは固定で「7」とし、
-- レビュテーブルのすべてのフィールドとレストランテーブルからレストラン名を抽出するものとする（task-45.sql）。
select res.name, rev.restaurant, rev.comment, rev.reviewer, rev.rating
from reviews rev
join restaurants res on res.id = rev.restaurant
where rev.restaurant = "7";