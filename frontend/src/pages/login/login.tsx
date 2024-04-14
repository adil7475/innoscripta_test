import React, { useEffect, useState } from "react"
import { NavLink } from "react-router-dom"
import { useLoginAPI } from "../../services/login-api/use-login-api"
import * as Yup from "yup"
import { useFormik } from "formik";
import { Container, Row, Col, Card, Form, FormGroup, Button, CardBody, Input, Label, CardTitle } from "reactstrap"
import { useRecoilValue } from "recoil";
import {serverErrors} from "../../store/server-error/server-error";
import {loader} from "../../store/loader/loader";

export const Login = () => {
    const { login } = useLoginAPI()
    const loginFormServerErrors: any = useRecoilValue(serverErrors)
    const loading = useRecoilValue(loader)
    const handleSubmit = async (values: any) => {
        await login(values.email, values.password)
    }

    const validationSchema = Yup.object({
        email: Yup.string()
            .email('Invalid Email.')
            .required('Email is required.'),
        password: Yup.string()
            .min(8, 'Password must contains 8 characters')
            .required('Password is required')
    })

    const formik = useFormik({
        initialValues: {email: '', password: ''},
        onSubmit: handleSubmit,
        validationSchema
    })

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>, inputName: string) => {
        formik.handleChange(e)
    }

    const {errors, touched} = formik
    return (
        <div className="login">
            <Container>
                <Row className="justify-content-center mt-5">
                    <Col lg="4" md="6" sm="6">
                        <Card className="shadow">
                            <CardTitle className="text-center">
                                <h2 className="p-3"><strong>Innoscripta</strong></h2>
                            </CardTitle>
                            <CardBody>
                                <Form onSubmit={formik.handleSubmit}>
                                    <FormGroup>
                                        <Label for="email">Email</Label>
                                        <Input 
                                            type="email" 
                                            id="email" 
                                            placeholder="Email"
                                            {...formik.getFieldProps('email')}
                                            onChange={(e) => handleInputChange(e, "email")}
                                        />
                                        {touched.email && errors.email && <span className='text-danger'>{errors.email}</span>}
                                        {loginFormServerErrors.email && <span>{ loginFormServerErrors.email }</span> }
                                    </FormGroup>
                                    <FormGroup>
                                        <Label for="password">Password</Label>
                                        <Input 
                                            type="password" 
                                            id="password" 
                                            placeholder="Password"
                                            {...formik.getFieldProps('password')}
                                            onChange={(e) => handleInputChange(e, "password")}
                                        />
                                        {touched.password && errors.password && <span className='text-danger'>{errors.password}</span>}
                                        {loginFormServerErrors.password && <span className='text-danger'>{ loginFormServerErrors.password }</span> }
                                    </FormGroup>
                                    <div className="mb-4">
                                        <p>New Account? <NavLink to="/register">Signup</NavLink></p>
                                    </div>
                                    <div className="d-grid">
                                        <Button type="submit" className="text-light cstm-btn py-2" disabled={loading}>
                                            LOGIN
                                        </Button>
                                    </div>
                                </Form>
                            </CardBody>
                        </Card>
                    </Col>
                </Row>
            </Container>
        </div>
    )
}