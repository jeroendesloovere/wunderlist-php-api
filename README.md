Wunderlist2-PHP-Wrapper
=======================

A PHP Wrapper for Wunderlist2 API

Extra's:
ical.php: this file generates a valid ical file which uses the due dates of tasks to generate a "to-do" calendar. For mac users: https://www.apple.com/findouthow/mac/#subscribeical

Currently supported methods:
- Login to Wunderlist API
- Get all tasks
- Get all lists
- Get all tasks within a list

Subtasks are automatically added to their parent instead as a single task
By setting a parameter to the functions for tasks you can specify if completed tasks should be hidden or not.


Future - but soon enough - functions:
- Create a task
- Set due date for a task
- Add notes to a task
- Delete a task
- Add list
- Delete list
- Get reminders
- Set reminder for a task
