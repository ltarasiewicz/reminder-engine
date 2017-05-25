#!/bin/sh

export MONGODB_CONNECTION_STRING=$(aws ssm get-parameters --region ap-southeast-2 --names mongodb-connection-string --query Parameters[0].Value)
export MAILHUB=$(aws ssm get-parameters --region ap-southeast-2 --names mailhub --query Parameters[0].Value)
export AUTH_USER=$(aws ssm get-parameters --region ap-southeast-2 --names auth-user --query Parameters[0].Value)
export AUTH_PASS=$(aws ssm get-parameters --region ap-southeast-2 --names auth-pass --query Parameters[0].Value)
