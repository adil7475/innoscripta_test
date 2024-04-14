import React from 'react';
import * as Yup from "yup"
import {Button, Card, CardBody, CardTitle, Col, Container, Form, FormGroup, Input, Label, Row} from "reactstrap";
import {NavLink} from "react-router-dom";
import { useFormik } from "formik";
import { useRecoilValue } from "recoil";
import {serverErrors} from "../../store/server-error/server-error";
import {loader} from "../../store/loader/loader";
import {useRegisterAPI} from "../../services/register-api/use-register-api";

export const Register = () => {
    const loading: boolean = useRecoilValue(loader)
    const registerFormServerErrors: any = useRecoilValue(serverErrors)
    const { Register } = useRegisterAPI()

    const validationSchema = Yup.object({
        name: Yup.string()
            .required('Name is required'),
        email: Yup.string()
            .email('Invalid Email.')
            .required('Email is required.'),
        password: Yup.string()
            .min(8, 'Password must contains 8 characters')
            .required('Password is required'),
        password_confirmation: Yup.string()
            .required("This field is required!")
            .oneOf([Yup.ref('password')], 'Passwords does not matched.')
    })

    const handleSubmit = async (values: any) => {
        await Register(values.name, values.email, values.password)
    }

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>, inputName: string) => {
        formik.handleChange(e)
    }

    const formik = useFormik({
        initialValues: {name: '', email: '', password: '', password_confirmation: ''},
        onSubmit: handleSubmit,
        validationSchema
    })

    const {errors, touched} = formik

    return (
        <div className="register">
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
                                        <Label for="name">Name</Label>
                                        <Input
                                            type="text"
                                            id="name"
                                            placeholder="Name"
                                            {...formik.getFieldProps('name')}
                                            onChange={(e) => handleInputChange(e, "email")}
                                        />
                                        {touched.name && errors.name && <span className='text-danger'>{errors.name}</span>}
                                        {registerFormServerErrors.name && <span>{registerFormServerErrors.name}</span>}
                                    </FormGroup>
                                    <FormGroup>
                                        <Label for="email">Email</Label>
                                        <Input
                                            type="email"
                                            id="email"
                                            placeholder="Email"
                                            {...formik.getFieldProps('email')}
                                            onChange={(e) => handleInputChange(e, "email")}
                                        />
                                        {touched.email && errors.email &&
                                            <span className='text-danger'>{errors.email}</span>}
                                        {registerFormServerErrors.email && <span>{registerFormServerErrors.email}</span>}
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
                                        {touched.password && errors.password &&
                                            <span className='text-danger'>{errors.password}</span>}
                                        {registerFormServerErrors.password &&
                                            <span className='text-danger'>{registerFormServerErrors.password}</span>}
                                    </FormGroup>
                                    <FormGroup>
                                        <Label for="password_confirmation">Confirm Password</Label>
                                        <Input
                                            type="password"
                                            id="password_confirmation"
                                            placeholder="Confirm Password"
                                            {...formik.getFieldProps('password_confirmation')}
                                            onChange={(e) => handleInputChange(e, "password_confirmation")}
                                        />
                                        {touched.password_confirmation && errors.password_confirmation &&
                                            <span className='text-danger'>{errors.password_confirmation}</span>}
                                        {registerFormServerErrors.password_confirmation &&
                                            <span className='text-danger'>{registerFormServerErrors.password_confirmation}</span>}
                                    </FormGroup>
                                    <div className="mb-4">
                                        <p>Already have an account? <NavLink to="/login">Login</NavLink></p>
                                    </div>
                                    <div className="d-grid">
                                        <Button type="submit" className="text-light cstm-btn py-2" disabled={loading}>
                                            REGISTER
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