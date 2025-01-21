moodle-availability_recompletion
========================

Moodle availability plugin which lets users restrict resources, activities and sections based on recompletion of the selected course.


Requirements
------------

This plugin requires Moodle 4.1+.   
This plugin requires the plugin Course recompletion [local_recompletion](https://moodle.org/plugins/local_recompletion).  


Motivation for this plugin
--------------------------

The plugin Course recompletion [local_recompletion](https://moodle.org/plugins/local_recompletion) allows clearing all course and activity completion for a user based on the duration set notifying the student they need to return to the course and recomplete it.

The problem is that, once the completion is removed, it is no longer possible to distinguish between users who have never completed the course and users who have completed the course but their completion has been removed.

This plugin allows you to:
- show or hide elements only for users who have never completed the course
- show or hide elements only for users who have completed the course and their completion has been removed.


Installation
------------

Install the plugin like any other plugin to folder moodle/availability/condition/recompletion.   

The folder structure should therefore be:
```
| moodle
  |-- availability
    |-- condition
      |-- recompletion
        |-- classes
        |-- lang
        |-- tests
        |-- yui
        ...                
```      

See http://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins


List of selectable courses
--------------------------

A course X is present in the dropdown menu in 'Settings / Restrict access' if:
- recompletion has been enabled for course X
- there is at least one user of course X whose completion has been removed using the plugin [Course recompletion](https://moodle.org/plugins/local_recompletion)


Dependencies 
------------

The plugin [local_recompletion](https://moodle.org/plugins/local_recompletion) records all the data in tables whose names start with `local_recompletion_`.

This plugin only reads the data present in the `local_recompletion_cc` and `local_recompletion_config` tables.
If in the future the table used by the local_recompletion plugin changes then must be modified the two queries present in the methods:   
- class condition, function is_available
- class frontend, function get_javascript_init_params


Example
-------

### EN

Upon certificate expiration, users are automatically removed from the safety course using the recompletion plugin.

Once removed, it is no longer possible to distinguish between new users and those who need to renew it.

Users taking the course for the first time must do so in-person in the classroom.
Students who need to renew the certificate can do so only online.

This plugin allows distinguishing between users who have never completed the course and those who have completed it at least once but whose certificate has expired.

Students who have never completed the course will be able to access the activity that allows enrollment in the in-person course.
Students who have already taken the course and whose certificate has expired and need to retake the course will not be able to access the activity that allows enrollment in the in-person course. However, they will be able to enroll in and access the activities of a different course that does not require classroom attendance.

### IT
 
Alla scadenza del certificato gli utenti vengono rimossi automaticamente dal corso di sicurezza usando il plugin recompletion. 

Una volta rimossi non è più possibile distinguere tra gli utenti nuovi e quelli che devono rinnovarlo.

Gli utenti che frequentano il corso per la prima volta devono farlo in presenza in aula.   
Gli studenti che devono rinnovare il certificato possono farlo solo online.
 
Questo plugin permette di distinguere tra gli utenti che non hanno mai completato il corso e quelli che hanno già completato il corso almeno una volta ma il cui certificato è scaduto.

Gli studenti che non hanno mai completato il corso potranno accedere all'attività che permette l'iscrizione al corso in presenza.   
Gli studenti che hanno già frequentato il corso e a cui è scaduto il certificato e devono rifare il corso non potranno accedere all'attività che permette l'iscrizione al corso in presenza. Potranno eventualmente iscriversi e accedere alle attività di un differente corso che non prevede la presenza in aula. 


Usage & Settings
----------------

After installing the plugin, it is ready to use without the need for any configuration.

Teachers (and other users with editing rights) can add the "Recompletion" availability condition to activities in their courses. While adding the condition, they have to define the course to which the recompletion refers.

As Moodle admin, you have already created two course: in-person (course A) and renewal (course B).

### Course A

The administrator/teacher must restrict the enrollment activities for the in-person lessons of course A to students who are taking the course for the first time.

The teacher, when adding a new choicegroup activity for "Prenotazione edizione x", in "Settings / Restrict access" must add "Student Restriction type MUST NOT match the following: Must have undone the course completion THIS COURSE".

IT "Impostazioni / Condizioni per l'accesso" -> "Lo studente NON DEVE soddisfare il seguente criterio: Deve aver annullato il completamento del corso QUESTO CORSO".

### Course B

The administrator/teacher must restrict the activities of course B to students who, for example, only need to renew the certificate.

The teacher, in "Settings / Restrict access" for individual activities, must add "Student Restriction type MUST match the following: Must have undone the course completion COURSE A".

IT "Impostazioni / Condizioni per l'accesso" -> "Lo studente DEVE soddisfare il seguente criterio: Deve aver annullato il completamento del corso COURSE A".
