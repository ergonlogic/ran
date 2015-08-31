from celery import Celery
import subprocess
import urllib, urllib2
import time
import json

app = Celery('tasks', broker='amqp://guest@localhost//', backend='amqp')
app.conf.CELERY_RESULT_SERIALIZER = "json"
app.conf.CELERY_TASK_RESULT_EXPIRES = None
app.conf.CELERY_TRACK_STARTED = False

def run_cmd(task, cmd):
    post_log(task, "Running command: "+" ".join(cmd), 0)
    p = subprocess.Popen(cmd, stdout=subprocess.PIPE, stderr=subprocess.STDOUT, bufsize=1)
    i = 1
    for line in iter(p.stdout.readline, b''):
        post_log(task, line, i),
        i += 1
    p.stdout.close()
    p.wait()

def post_log(task, output, seq):
    url = 'http://ran.dev/ran/queue/post_task_log'
    task_post = {
        'task_id' : task['id'],
        'task_ref_id' : task['ref_id'],
        'task_sequence' : seq,
        'timestamp' : time.time(),
        'task_output' : output,
    }
    data = urllib.urlencode(task_post)
    req = urllib2.Request(url, data)
    urllib2.urlopen(req)
    #response = urllib2.urlopen(req)
   # the_page = response.read()

@app.task
def write_playbook(task, extra_vars):
    # Run playbook to generate resource/host playbooks from templates.
    # Return output or post data to write_post URL.
    task = json.loads(task)
    cmd = ["sudo", "PYTHONUNBUFFERED=1", "ANSIBLE_FORCE_COLOR=true", "/usr/local/bin/ansible-playbook", "/usr/local/share/ran/ansible/site.yml", "-i", "/usr/local/share/ran/tests/inventory", "--sudo", "--extra-vars="+extra_vars]
    run_cmd(task, cmd)

@app.task
def run_playbook(task, org, project, type, name):
    task = json.loads(task)
    playbook = "/var/ran/"+org+"/"+project+"/"+type+"/"+name+".yml"
    extra_vars = json.dumps({"ran_project_path":"/var/ran/"+org+"/"+project})
    cmd = ["sudo", "PYTHONUNBUFFERED=1", "ANSIBLE_FORCE_COLOR=true", "/usr/local/bin/ansible-playbook", playbook, "-i", "/usr/local/share/ran/tests/inventory", "--sudo", "--extra-vars="+extra_vars]
#    cmd = ["sudo", "PYTHONUNBUFFERED=1", "ANSIBLE_FORCE_COLOR=true", "/usr/local/bin/ansible-playbook", playbook, "-i", "/usr/local/share/ran/tests/inventory", "--sudo"]
    run_cmd(task, cmd)


@app.task
def import_playbook():
    # Read playbook YAML data
    # Return output or post data to import_post URL
    return True

