select * from location
inner join activity
on location.userID = activity.userID
and location.timestamp_l = activity.timestamp_l
inner join activity_details
on activity.userID = activity_details.userID
and activity.timestamp_l = activity_details.timestamp_l
and activity.timestamp_a = activity_details.timestamp_a
where activity_details.type in (select * from activity_table);
