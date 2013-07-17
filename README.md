Wunderlist2-PHP-Wrapper
=======================

A PHP Wrapper for Wunderlist2 API
- Current version: 1.00

Thanks go out to these two Github projects, they gave me insight in the way the Wunderlist API works.
- https://github.com/bsmt/wunderpy
- https://github.com/rushis/Wunderlist2ApiJS

Extra's:
ical.php: this file generates a valid ical file which uses the due dates of tasks to generate a "to-do" calendar. 
- For mac agenda users: https://www.apple.com/findouthow/mac/#subscribeical
- For Google calendar users: https://support.google.com/calendar/answer/37118?hl=en
- For other apps/software: check the ability to (auto) import ical files to your app/software

Currently supported methods (Examples are included in the /examples/ folder)

- Login to Wunderlist API (15/07/2013 - v0.1)
- Get all tasks (15/07/2013 - v0.1)
- Get all lists (15/07/2013 - v0.1)
- Get all tasks within a list (15/07/2013 - v0.1)
- Add a list (16/07/2013 - v0.2)
- Add a task (16/07/2013 - v0.2)
- Set due date for a task (16/07/2013 - v0.2)
- Add notes to a task (16/07/2013 - v0.2)
- Delete a task (16/07/2013 - v0.2)
- Delete list (16/07/2013 - v0.2)
- Get reminders (17/07/2013 - v0.9)
- Set reminder for a task (17/07/2013 - v0.9)

Subtasks are automatically added to their parent instead as a single task
By setting a parameter to the functions for tasks you can specify if completed tasks should be hidden or not.

Future planned updates:
- 1st priority: add usable errors to the class instead of (bool)false
- 2nd priority: Get tasks for today
- 2nd priority: Get tasks for this week
- 2nd priority: Get all tasks that are overdue
- 3th priority: Filter tasklist by due date
- 3th priority: Filter tasklist by starred tasks
- 4th priority: Add iCal export as a function to the class instead as a single file
