Wunderlist2-PHP-Wrapper
=======================

A PHP Wrapper for Wunderlist2 API
- Current version: 1.02

Latest news about the class:
26/07/2013: I've been playing around a little with the new function "Files". I've created a new class called Wunderfiles (api.files.class.php) and put the call() method in an own class (Wunderbase: base.class.php). Both classes (Wunderlist & Wunderfiles) extend from this base class. Furthermore the call() method and $api_url variables have been made protected to work across the other classes. The $authtoken variable from class Wunderlist is now public, this way you can send it along to the Wunderfiles class with requires the token to be set on construction of the class (See /examples/getFiles.php). As for now: IT IS NOT WORKING YET(!). It's a quick draft of how it would look in the future as soon as I figure out a way to get the files working (and I'm not sure yet if there's an ability to get this working at all!). Next updates are coming pretty soon (tasks for today, next week & overdue)! 

Thanks go out to these two Github projects, they gave me insight in the way the Wunderlist API works.
- https://github.com/bsmt/wunderpy
- https://github.com/rushis/Wunderlist2ApiJS

Extra's:
ical.php: this file generates a valid ical file which uses the due dates of tasks to generate a "to-do" calendar. 
- For mac agenda users: https://www.apple.com/findouthow/mac/#subscribeical
- For Google calendar users: https://support.google.com/calendar/answer/37118?hl=en
- For other apps/software: check the ability to (auto) import ical files to your app/software

Not familiar with PHP, but looking for a way to get your tasks in your calender? Take a look at http://wcal.me/ - we've created this free webservice for anyone that wants his/her tasks in their calender/agenda app!

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
- 1st priority: Get tasks for today
- 1st priority: Get tasks for this week
- 1st priority: Get all tasks that are overdue
- 2nd priority: Filter tasklist by due date
- 2nd priority: Filter tasklist by starred tasks
- 3th priority: Add iCal export as a function to the class instead as a single file
- 4rd priority: See if Wunderlist Files can be added to the PHP Wrapper
