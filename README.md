Wunderlist2-PHP-Wrapper
=======================

A PHP Wrapper for Wunderlist2 API

Thanks goes out to these two Github projects, they gave me insight in the working of the Wunderlist API and the ability to get the functions working.
- https://github.com/bsmt/wunderpy
- https://github.com/rushis/Wunderlist2ApiJS

Extra's:
ical.php: this file generates a valid ical file which uses the due dates of tasks to generate a "to-do" calendar. 
- For mac agenda users: https://www.apple.com/findouthow/mac/#subscribeical
- For Google calendar users: https://support.google.com/calendar/answer/37118?hl=en
- For other apps/software: check the ability to (auto) import ical files to your app/software

Currently supported methods:
- Login to Wunderlist API
- Get all tasks
- Get all lists
- Get all tasks within a list
- Add a list
- Add a task

Subtasks are automatically added to their parent instead as a single task
By setting a parameter to the functions for tasks you can specify if completed tasks should be hidden or not.

Future - but soon enough - functions:
- Set due date for a task
- Add notes to a task
- Delete a task
- Delete list
- Get reminders
- Set reminder for a task

After the basic functionality I will add some more advanced filtering such as:
- Get tasks for today
- Get tasks for this week
- Get all tasks that are overdue
- Filter tasklist by due date
- Filter tasklist by starred tasks
